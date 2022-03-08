<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Article;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Database\Seeders\ArticleSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminManageArticleControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testAdminHasAccessToManagePage()
    {
        $user = User::factory()->create([
            'is_admin' => true
        ]);

        $this->actingAs($user);

        $response = $this->get(route('admin_manage_articles_index'));
        $response->assertOk();
    }

    public function testUserDoesNotHaveAccessToManagePage()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->get(route('admin_manage_articles_index'));
        $response->assertRedirect(RouteServiceProvider::HOME);
    }

    public function testGuestDoesNotHaveAccessToManagePage()
    {
        $response = $this->get(route('admin_manage_articles_index'));
        $response->assertRedirect(RouteServiceProvider::HOME);
    }

    public function testAdminCanDeleteNonOwnArticles()
    {
        $this->seed([UserSeeder::class, ArticleSeeder::class]);

        $user = User::factory()->create(['is_admin' => true]);
        $article = Article::query()->first();

        $this->actingAs($user);

        $response = $this->delete(route('admin_manage_articles_destroy', $article));
        $response->assertRedirect();

        $this->assertDatabaseMissing('articles', $article->getAttributes());
    }
}
