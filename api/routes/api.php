<?php

use App\Http\Middleware\Auth;
use App\Http\Middleware\EnforceHeaders;
use App\Http\Middleware\ParseCookies;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;


Route::middleware(EnforceHeaders::Class)->group(function () {
    Route::get('/', function () {
        return response()->json(['message' => 'API is up and running']);
    });

    Route::prefix('auth')->group(function () {
        Route::post('/register', [AuthController::class, 'register'])->name('api.auth.register');
        Route::post('/login', [AuthController::class, 'login'])->name('api.auth.login');
        Route::middleware(Auth::Class)->post('/logout', [AuthController::class, 'logout'])->name('api.auth.logout');
        Route::post('/refresh', [AuthController::class, 'refreshToken'])->name('api.auth.refresh');
    });

    //Protected routes
    Route::middleware(Auth::Class)->group(function () {
        Route::prefix('user')->group(function () {
            Route::get('/me', [UserController::class, 'me'])->name('api.user.me');
        });
    });

});
