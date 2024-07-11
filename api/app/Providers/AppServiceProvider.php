<?php

namespace App\Providers;

use app\Contracts\Repositories\ItemRepositoryContract;
use app\Contracts\Repositories\OrderRepositoryContract;
use app\Contracts\Repositories\RestaurantRepositoryContract;
use app\Contracts\Repositories\TableRepositoryContract;
use app\Contracts\Repositories\UserRepositoryContract;
use app\Contracts\Services\AuthServiceContract;
use App\Repositories\ItemRepository;
use App\Repositories\OrderRepository;
use App\Repositories\RestaurantRepository;
use App\Repositories\TableRepository;
use App\Repositories\UserRepository;
use App\Services\AuthService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            UserRepositoryContract::class,
            UserRepository::class
        );

        $this->app->bind(
            AuthServiceContract::class,
            AuthService::class
        );

        $this->app->bind(
            OrderRepositoryContract::class,
            OrderRepository::class
        );

        $this->app->bind(
            RestaurantRepositoryContract::class,
            RestaurantRepository::class
        );

        $this->app->bind(
            ItemRepositoryContract::class,
            ItemRepository::class
        );

        $this->app->bind(
            TableRepositoryContract::class,
            TableRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
