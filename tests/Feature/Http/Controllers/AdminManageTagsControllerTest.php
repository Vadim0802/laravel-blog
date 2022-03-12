<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Tag;
use App\Models\User;
use Database\Seeders\TagSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AdminManageTagsControllerTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(TagSeeder::class);
        $this->admin = User::factory()->create([
            'is_admin' => true
        ]);
    }

    public function testIndex()
    {
        $this->actingAs($this->admin);

        $response = $this->get(route('admin_manage_tags_index'));
        $response->assertOk();
    }

    public function testAdminCanDeleteTags()
    {
        $tag = Tag::query()->first();

        $this->actingAs($this->admin);

        $response = $this->delete(route('admin_manage_tags_destroy', $tag));
        $response->assertRedirect();

        $this->assertDatabaseMissing('tags', $tag->getAttributes());
    }

    public function testAdminCanAddNewTags()
    {
        $tag = Tag::factory()->make();
        $data = [
            'name' => $tag->name
        ];

        $this->actingAs($this->admin);

        $response = $this->post(route('admin_manage_tags_store', $data));
        $response->assertRedirect();
        $response->assertSessionDoesntHaveErrors();

        $this->assertDatabaseHas('tags', $data);
    }
}
