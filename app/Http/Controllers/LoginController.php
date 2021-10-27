<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /** Login User
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (is_null($user)) {
            return response()->json([
                'error' => 'There is no user with such email.'
            ], 403);
        }

        if(Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $token = $user->createToken('Basic');
            return response()->json([
                $token->accessToken->name => $token->plainTextToken
            ]);
        } else {
            return response()->json([
                'error' => 'An email or password is wrong.'
            ], 403);
        }
    }
}
