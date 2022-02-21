<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleLike;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArticleLikeControllerTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Article $article;

    protected function setUp(): void
    {
        parent::setUp();
        $user = User::factory()->create();

        /* @var Article $article */
        $article = Article::factory()->make();
        $article->author()->associate($user);
        $article->save();

        $this->user = $user;
        $this->article = $article;

        $this->actingAs($this->user);
    }

    public function testIndex()
    {
        $response = $this->get(route('articles.likes.index', $this->article));
        $response->assertOk();
    }

    public function testStore()
    {
        $response = $this->post(route('articles.likes.store', $this->article));
        $response->assertRedirect();

        $this->assertDatabaseHas('article_likes', [
            'user_id' => $this->user->id,
            'article_id' => $this->article->id
        ]);
    }

    public function testStoreWithExistingLike()
    {
        $this->createLike($this->user, $this->article);

        $response = $this->post(route('articles.likes.store', $this->article));
        $response->assertRedirect();

        $this->assertDatabaseCount('article_likes', 1);
    }

    public function testDestroy()
    {
        $like = $this->createLike($this->user, $this->article);
        $likeData = $like->only(['user_id', 'article_id']);

        $response = $this->delete(route('articles.likes.destroy', [$this->article, $like]));
        $response->assertRedirect();

        $this->assertDatabaseMissing('article_likes', $likeData);
    }

    public function createLike($user, $article): ArticleLike
    {
        $like = new ArticleLike();
        $like->user()->associate($user);
        $like->article()->associate($article);
        $like->save();

        return $like;
    }
}
