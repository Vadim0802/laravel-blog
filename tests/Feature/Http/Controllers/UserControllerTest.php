<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    private User $user;
    private string $password;

    public function setUp(): void
    {
        parent::setUp();

        $this->password = $this->faker->password(8);
        $this->user = User::factory()->create([
            'password' => Hash::make($this->password)
        ]);
        $this->actingAs($this->user);
    }

    public function testShow()
    {
        $response = $this->get(route('users.show', $this->user));
        $response->assertOk();
    }

    public function testEdit()
    {
        $response = $this->get(route('users.edit', $this->user));
        $response->assertOk();
    }

    public function testUpdate()
    {
        $userData = collect([
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'password' => $this->faker->password(8)
        ]);
        $response = $this->patch(route('users.update', $this->user), $userData->all());
        $response->assertSessionDoesntHaveErrors();
        $response->assertRedirect();

        $this->assertDatabaseHas('users', $userData
            ->except(['password'])
            ->all());
    }
}
