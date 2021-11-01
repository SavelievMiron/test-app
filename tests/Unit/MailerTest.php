<?php

namespace Tests\Unit;

use App\Mail\ResetPasswordMail;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class MailerTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    protected UserService $userService;

    public function setUp(): void
    {
        parent::setUp();
        $this->userService = $this->app->make(UserService::class);
    }
    /**
     * Test sending reset password token
     *
     * @return void
     */
    public function testSendingResetPasswordToken()
    {
        Mail::fake();

        $data = [
            'email' => $this->faker->safeEmail(),
            'password' => Hash::make($this->faker->password())
        ];

        $user = User::factory()->create($data);

        $resetPasswordToken = $this->userService->createResetPasswordToken($user);

        Mail::to($data['email'])->send(new ResetPasswordMail([
            'user' => $user,
            'token' => $resetPasswordToken->plainTextToken
        ]));

        Mail::assertSent(ResetPasswordMail::class);

        Mail::assertSent(ResetPasswordMail::class, function ($mail) {
            $mail->build();
            $this->assertTrue($mail->hasTo($mail->details['user']->email));

            return true;
        });
    }
}
