<?php

namespace Tests\Feature;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LoginUserTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    protected UserService $userService;

    public function setUp(): void
    {
        parent::setUp();
        $this->userService = $this->app->make(UserService::class);
    }

    /**
     * Test login user
     *
     * @return void
     */
    public function testLoginUser()
    {
        $data = [
            'email' => $this->faker->safeEmail(),
            'password' => $this->faker->password()
        ];

        User::factory()->create([
            'email' => $data['email'],
            'password' => Hash::make($data['password'])
        ]);

        $response = $this->json('POST', "{$_ENV['APP_URL']}login", $data);

        $response->assertStatus(200);
        $response->assertJson([
            'Basic' => true
        ]);
    }
}
