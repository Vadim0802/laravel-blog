<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleComment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ArticleCommentControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    private User $user;
    private Article $article;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->article = Article::factory()->make();
        $this->article->author()->associate($this->user);
        $this->article->save();

        $this->actingAs($this->user);
    }

    public function testStore()
    {
        $commentData = [
            'content' => $this->faker->sentence(5),
        ];

        $response = $this->post(route('articles.comments.store', $this->article), $commentData);
        $response->assertSessionDoesntHaveErrors();
        $response->assertRedirect();

        $this->assertDatabaseHas('article_comments', array_merge($commentData, [
            'user_id' => $this->user->id,
            'article_id' => $this->article->id
        ]));
    }

    public function testEdit()
    {
        $comment = $this->createComment($this->user, $this->article);

        $response = $this->get(route('articles.comments.edit', [$this->article, $comment]));

        $response->assertOk();
    }

    public function testUpdate()
    {
        $comment = $this->createComment($this->user, $this->article);

        $commentData = [
            'content' => $this->faker->sentence(5)
        ];

        $response = $this->patch(route('articles.comments.update', [$this->article, $comment]), $commentData);

        $response->assertSessionDoesntHaveErrors();
        $response->assertRedirect();

        $this->assertDatabaseHas('article_comments', array_merge($commentData, [
            'user_id' => $this->user->id,
            'article_id' => $this->article->id
        ]));
    }

    public function testDestroy()
    {
        $comment = $this->createComment($this->user, $this->article);
        $commentData = $comment->only(['id', 'content', 'user_id', 'article_id']);

        $response = $this->delete(route('articles.comments.destroy', [$this->article, $comment]));

        $response->assertRedirect();

        $this->assertDatabaseMissing('article_comments', $commentData);
    }

    public function createComment($user, $article)
    {
        /* @var ArticleComment $comment */
        $comment = ArticleComment::factory()->make();
        $comment->user()->associate($user);
        $comment->article()->associate($article);
        $comment->save();

        return $comment;
    }
}
