<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::post('users', [UserController::class, 'create']);
Route::post('login', [LoginController::class, 'login']);

Route::post('create-reset-token', [ResetPasswordController::class, 'createResetPasswordToken']);
Route::post('reset-password', [ResetPasswordController::class, 'resetPassword']);
