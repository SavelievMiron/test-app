<?php

namespace App\Services;

use App\Models\ResetPassword;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class UserService
{
    /** Create User
     *
     * @param array $data
     * @return mixed
     */
    public function createUser(array $data)
    {
        return User::create([
           'email' => $data['email'],
           'password' =>  Hash::make($data['password'])
        ]);
    }

    /** Create reset password token
     *
     * @param User $user
     * @return \Laravel\Sanctum\NewAccessToken
     */
    public function createResetPasswordToken(User $user)
    {
        $token = $user->createToken('ResetPassword');

        $user->resetPassword()->create([
            'token' => $token->plainTextToken
        ]);

        return $token;
    }

    /** Reset user password
     *
     * @param array $data
     * @return string[]|void
     */
    public function resetPassword(array $data)
    {
        $resetPassword = ResetPassword::where('token', $data['token'])->first();

        $creation_time = $resetPassword->created_at;
        $curr_time = Carbon::now();

        if($curr_time->diff($creation_time)->h > 2) {
            return [
                'error' => 'The token has expired. Request a new token.'
            ];
        }

        $user = $resetPassword->user;
        $user->password = Hash::make($data['password']);
        $user->save();

        $resetPassword->delete();
    }
}
