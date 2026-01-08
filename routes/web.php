<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return response()->json([
        'message' => 'Laravel Sanctum API',
        'version' => '1.0.0',
        'endpoints' => [
            'register' => [
                'method' => 'POST',
                'url' => '/api/register',
                'description' => 'Register a new user'
            ],
            'login' => [
                'method' => 'POST',
                'url' => '/api/login',
                'description' => 'Login and get access token'
            ],
            'user' => [
                'method' => 'GET',
                'url' => '/api/user',
                'description' => 'Get authenticated user details (requires token)'
            ],
            'logout' => [
                'method' => 'POST',
                'url' => '/api/logout',
                'description' => 'Logout and revoke token (requires token)'
            ]
        ],
        'documentation' => 'See README.md for full documentation'
    ]);
});
