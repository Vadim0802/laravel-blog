<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Article;
use App\Models\Tag;
use App\Models\User;
use Database\Seeders\TagSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

use function route;

class ArticleControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    }

    public function testIndex()
    {
        $response = $this->get(route('articles.index'));
        $response->assertOk();
    }

    public function testIndexWithFilter()
    {
        $article = $this->createArticle($this->user);

        $response = $this->get(route('articles.index', ['search' => $article->title]));
        $response->assertOk();
    }

    public function testCreate()
    {
        $response = $this->get(route('articles.create'));
        $response->assertOk();
    }

    public function testStore()
    {
        $this->seed(TagSeeder::class);
        $tags = Tag::all('id')->map(fn ($item) => $item['id']);

        $articleData = collect([
            'title' => $this->faker->sentence(5),
            'content' => $this->faker->sentence(100),
            'tags' => $tags->toArray()
        ]);

        $response = $this->post(route('articles.store'), $articleData->toArray());
        $response->assertSessionDoesntHaveErrors();
        $response->assertRedirect();

        $articleData = $articleData->merge([
                'slug' => Str::slug($articleData['title']),
                'user_id' => $this->user->id
            ])->except(['tags'])->toArray();

        $this->assertDatabaseHas('articles', $articleData);
        $this->assertDatabaseCount('article_tag', $tags->count());
    }

    public function testGuestCannotStore()
    {
        $articleData = [
            'title' => $this->faker->sentence(5),
            'content' => $this->faker->sentence(100),
        ];

        auth()->logout();

        $response = $this->post(route('articles.store'), $articleData);
        $response->assertForbidden();
    }

    public function testShow()
    {
        $article = $this->createArticle($this->user);

        $response = $this->get(route('articles.show', $article));
        $response->assertOk();
    }

    public function testEdit()
    {
        $article = $this->createArticle($this->user);

        $response = $this->get(route('articles.edit', $article));
        $response->assertOk();
    }

    public function testUpdate()
    {
        $article = $this->createArticle($this->user);
        $this->seed(TagSeeder::class);
        $article->tags()->detach(Tag::all());

        $tag = Tag::all('id')->first();

        $articleData = collect([
            'title' => $this->faker->sentence(5),
            'content' => $this->faker->sentence(50),
            'tags' => [$tag->id]
        ]);

        $response = $this->patch(route('articles.update', $article), $articleData->toArray());
        $response->assertSessionDoesntHaveErrors();
        $response->assertRedirect();

        $this->assertDatabaseHas('articles', $articleData
            ->merge([
                'slug' => Str::slug($articleData['title']),
                'user_id' => $this->user->id
            ])
            ->except(['tags'])
            ->toArray());

        $this->assertDatabaseCount('article_tag', 1);
    }

    public function testGuestCannotUpdateArticles()
    {
        $article = $this->createArticle($this->user);

        $articleData = [
            'title' => $this->faker->sentence(5),
            'content' => $this->faker->sentence(50),
        ];

        auth()->logout();

        $response = $this->patch(route('articles.update', $article), $articleData);
        $response->assertForbidden();
    }

    public function testUserCannotUpdateNonOwnArticles()
    {
        $article = $this->createArticle($this->user);

        $articleData = [
            'title' => $this->faker->sentence(5),
            'content' => $this->faker->sentence(50),
        ];

        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->patch(route('articles.update', $article), $articleData);
        $response->assertForbidden();
    }

    public function testDestroy()
    {
        $article = $this->createArticle($this->user);
        $articleData = $article->only(['id', 'user_id', 'title', 'content', 'slug']);

        $response = $this->delete(route('articles.destroy', $article));

        $response->assertRedirect();

        $this->assertDatabaseMissing('articles', $articleData);
    }

    public function testGuestCannotDestroyArticles()
    {
        $article = $this->createArticle($this->user);

        auth()->logout();

        $response = $this->delete(route('articles.destroy', $article));
        $response->assertForbidden();
    }

    public function testUserCannotDestroyNonOwnArticles()
    {
        $article = $this->createArticle($this->user);

        auth()->logout();

        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->delete(route('articles.destroy', $article));
        $response->assertForbidden();
    }

    public function createArticle($user)
    {
        /* @var Article $article */
        $article = Article::factory()->make();
        $article->author()->associate($user);
        $article->save();

        return $article;
    }
}
