<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    protected UserService $userService;

    public function __construct()
    {
        $this->userService = new UserService();
    }
    
    /** Create User
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|confirmed'
        ]);

        $user = $this->userService->createUser([
            'email' => $request->input('email'),
            'password' => $request->input('password')
        ]);

        $token = $user->createToken('Basic');

        return response()->json([
            $token->accessToken->name => $token->plainTextToken
        ], 201);
    }
}
