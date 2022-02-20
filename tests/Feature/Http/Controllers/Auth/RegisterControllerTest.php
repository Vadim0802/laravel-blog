<?php

namespace Tests\Feature\Http\Controllers\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function testShowRegistrationForm()
    {
        $response = $this->get('/register');
        $response->assertOk();
    }

    public function testRegister()
    {
        $password = $this->faker->password(8);
        $userData = collect([
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'password' => $password,
        ]);

        $response = $this->post('/register', $userData
            ->merge(['password_confirmation' => $password])
            ->all());

        $response->assertSessionDoesntHaveErrors();
        $response->assertRedirect();

        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', $userData->except(['password'])->all());
    }
}
