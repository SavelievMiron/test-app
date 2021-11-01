<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ResetUserPasswordTest extends TestCase
{
    use WithFaker, RefreshDatabase;
    /**
     * Test reset user password
     *
     * @return void
     */
    public function testResetUserPassword()
    {
        $data = [
            'email' => $this->faker->safeEmail(),
            'password' => $this->faker->password()
        ];

        $user = User::factory()->create([
            'email' => $data['email'],
            'password' => Hash::make($data['password'])
        ]);

        $createRestPasswordToken = $this->json('POST', "{$_ENV['APP_URL']}create-reset-token", ['email' => $data['email']]);

        $createRestPasswordToken->assertStatus(200)->assertJson([
           'message' => true
        ]);

        $resetPasswordToken = $user->resetPassword->token;

        $new_password = $this->faker->password();

        $resetPassword = $this->json('POST', "{$_ENV['APP_URL']}reset-password", [
            'token' => $resetPasswordToken,
            'password' => $new_password,
            'password_confirmation' => $new_password
        ]);

        $resetPassword->assertStatus(200)->assertJson([
            'message' => true
        ]);
    }
}
