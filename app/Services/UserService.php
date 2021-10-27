<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    public function createUser(array $data)
    {
        return User::create([
           'email' => $data['email'],
           'password' => $data['password']
        ]);
    }
}
