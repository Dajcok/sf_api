<?php

use App\Http\Middleware\Auth;
use App\Http\Middleware\EnforceHeaders;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;


Route::middleware(EnforceHeaders::Class)->group(function () {
    Route::get('/', function () {
        return response()->json(['message' => 'API is up and running']);
    });

    Route::prefix('auth')->group(function () {
        Route::post('/register', [AuthController::class, 'register']);
        Route::post('/login', [AuthController::class, 'login']);
    });

    //Protected routes
    Route::middleware(Auth::Class)->group(function () {
        Route::prefix('user')->group(function () {
            Route::get('/me', [UserController::class, 'me']);
        });
    });

});
