<?php

namespace Tests\Feature;

use App\Services\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterUserTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function testRegisterUser()
    {
        $password = $this->faker->password();

        $data = [
            'email' => $this->faker->safeEmail(),
            'password' => $password,
            'password_confirmation' => $password
        ];

        $response = $this->json('POST', "{$_ENV['APP_URL']}users", $data);

        $response->assertStatus(201);
        $response->assertJson([
            'Basic' => true
        ]);
    }
}
