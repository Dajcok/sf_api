<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CRUD\CategoryController;
use app\Http\Controllers\CRUD\ItemController;
use app\Http\Controllers\CRUD\OrderController;
use app\Http\Controllers\CRUD\RestaurantController;
use app\Http\Controllers\CRUD\TableController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\Auth;
use App\Http\Middleware\EnforceHeaders;
use Illuminate\Support\Facades\Route;


Route::middleware(EnforceHeaders::Class)->group(function () {
    Route::get('/', function () {
        return response()->json(['message' => 'API is up and running']);
    });

    Route::prefix('auth')->group(function () {
        Route::post('/register', [AuthController::class, 'register'])->name('api.auth.register');
        Route::post('/login', [AuthController::class, 'login'])->name('api.auth.login');
        Route::middleware(Auth::Class)->post('/logout', [AuthController::class, 'logout'])->name('api.auth.logout');
        Route::post('/refresh', [AuthController::class, 'refreshToken'])->name('api.auth.refresh');
        Route::post('/customer', [AuthController::class, 'createCustomer'])->name('api.auth.customer');
    });

    //Protected routes
    Route::middleware(Auth::Class)->group(function () {
        Route::prefix('user')->group(function () {
            Route::get('/me', [UserController::class, 'me'])->name('api.user.me');
        });

        Route::prefix('order')->group(function () {
            Route::get('/', [OrderController::class, 'index'])->name('api.order.index');
            Route::get('/{id}', [OrderController::class, 'show'])->name('api.order.show');
            Route::post('/', [OrderController::class, 'store'])->name('api.order.store');
            Route::put('/{id}', [OrderController::class, 'update'])->name('api.order.update');
            Route::delete('/{id}', [OrderController::class, 'destroy'])->name('api.order.destroy');
        });

        Route::prefix('item')->group(function () {
            Route::get('/', [ItemController::class, 'index'])->name('api.item.index');
            Route::get('/{id}', [ItemController::class, 'show'])->name('api.item.show');
            Route::post('/', [ItemController::class, 'store'])->name('api.item.store');
            Route::put('/{id}', [ItemController::class, 'update'])->name('api.item.update');
            Route::delete('/{id}', [ItemController::class, 'destroy'])->name('api.item.destroy');
        });

        Route::prefix('restaurant')->group(function () {
            Route::get('/', [RestaurantController::class, 'index'])->name('api.restaurant.index');
            Route::get('/{id}', [RestaurantController::class, 'show'])->name('api.restaurant.show');
            Route::put('/{id}', [RestaurantController::class, 'update'])->name('api.restaurant.update');
        });

        Route::prefix('table')->group(function () {
            Route::get('/', [TableController::class, 'index'])->name('api.table.index');
            Route::get('/{id}', [TableController::class, 'show'])->name('api.table.show');
            Route::post('/', [TableController::class, 'store'])->name('api.table.store');
            Route::put('/{id}', [TableController::class, 'update'])->name('api.table.update');
            Route::delete('/{id}', [TableController::class, 'destroy'])->name('api.table.destroy');
        });

        Route::prefix('category')->group(function () {
            Route::get('/', [CategoryController::class, 'index'])->name('api.category.index');
            Route::get('/{id}', [CategoryController::class, 'show'])->name('api.category.show');
            Route::post('/', [CategoryController::class, 'store'])->name('api.category.store');
            Route::put('/{id}', [CategoryController::class, 'update'])->name('api.category.update');
            Route::delete('/{id}', [CategoryController::class, 'destroy'])->name('api.category.destroy');
        });
    });
});
