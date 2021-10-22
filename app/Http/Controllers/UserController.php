<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public function create(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|confirmed'
        ]);

        $user = User::create([
            'email' => $request->input('email'),
            'password' => $request->input('password')
        ]);

        $token = $user->createToken('Basic');

        return response()->json([
            $token->accessToken->name => $token->plainTextToken
        ], 201);
    }
}
