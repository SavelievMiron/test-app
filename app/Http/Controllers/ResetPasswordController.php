<?php

namespace App\Http\Controllers;

use App\Mail\ResetPasswordMail;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ResetPasswordController extends Controller
{
    protected UserService $userService;

    public function __construct(UserService $userService) {
        $this->userService = $userService;
    }

    public function createResetPasswordToken(Request $request)
    {
        $data = $request->validate([
           'email' => 'required|email'
        ]);

        $user = User::where('email', $data['email'])->first();

        if(is_null($user)) {
            return response()->json([
                'error' => 'There is no user with such email.'
            ], 403);
        }

        $token = $this->userService->createResetPasswordToken($user);

        Mail::to($data['email'])->send(new ResetPasswordMail(['user' => $user, 'token' => $token->plainTextToken]));

        return response()->json([
            'message' => 'Reset password token was successfully sent to your email.'
        ]);
    }

    public function resetPassword(Request $request) {
        $data = $request->validate([
            'token' => 'required|exists:reset_passwords',
            'password' => 'required|confirmed'
        ]);

        $reset_password = $this->userService->resetPassword($data);

        if(!empty($reset_password['error'])) {
            return response()->json([
                'error' => $reset_password['error']
            ], 403);
        }

        return response()->json([
            'message' => 'User password was successfully changed.'
        ]);
    }
}
