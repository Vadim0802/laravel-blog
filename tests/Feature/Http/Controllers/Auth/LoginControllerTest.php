<?php

namespace Tests\Feature\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function testShowLoginForm()
    {
        $response = $this->get('/login');
        $response->assertOk();
    }

    public function testLogin()
    {
        $password = $this->faker->password;
        $user = User::factory()->create(['password' => Hash::make($password)]);
        $userData = collect($user->only(['email']))->merge(['password' => $password]);

        $response = $this->post('/login', $userData->all());

        $response->assertSessionDoesntHaveErrors();
        $response->assertRedirect();

        $this->assertAuthenticatedAs($user);
    }
}
