<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\User;
use Database\Seeders\ArticleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

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
        $article = Article::factory()->make();
        $article->author()->associate($this->user);
        $article->save();

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
        $articleData = [
            'title' => $this->faker->sentence(5),
            'content' => $this->faker->sentence(100),
            'user_id' => $this->user->id
        ];

        $response = $this->post(route('articles.store'), $articleData);
        $response->assertSessionDoesntHaveErrors();
        $response->assertRedirect();

        $this->assertDatabaseHas('articles', array_merge($articleData, [
            'slug' => Str::slug($articleData['title'])
        ]));
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

        $articleData = [
            'title' => $this->faker->sentence(5),
            'content' => $this->faker->sentence(50),
            'user_id' => $this->user->id
        ];

        $response = $this->patch(route('articles.update', $article), $articleData);
        $response->assertSessionDoesntHaveErrors();
        $response->assertRedirect();

        $this->assertDatabaseHas('articles', array_merge($articleData, [
            'slug' => Str::slug($articleData['title'])
        ]));
    }

    public function testDestroy()
    {
        $article = $this->createArticle($this->user);
        $articleData = $article->only(['id', 'user_id', 'title', 'content', 'slug']);

        $response = $this->delete(route('articles.destroy', $article));

        $response->assertRedirect();

        $this->assertDatabaseMissing('articles', $articleData);
    }

    public function createArticle($user)
    {
        $article = Article::factory()->make();
        $article->author()->associate($user);
        $article->save();

        return $article;
    }
}
