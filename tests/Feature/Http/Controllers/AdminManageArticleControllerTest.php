<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\User;
use App\Providers\RouteServiceProvider;
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
}
