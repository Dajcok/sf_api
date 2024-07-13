<?php

namespace App\Providers;

use App\Contracts\Repositories\ItemRepositoryContract;
use App\Contracts\Repositories\OrderRepositoryContract;
use App\Contracts\Repositories\RestaurantRepositoryContract;
use App\Contracts\Repositories\TableRepositoryContract;
use App\Contracts\Repositories\UserRepositoryContract;
use App\Contracts\Services\AuthServiceContract;
use App\Models\User;
use App\Observers\UserObserver;
use App\Repositories\ItemRepository;
use App\Repositories\OrderRepository;
use App\Repositories\RestaurantRepository;
use App\Repositories\TableRepository;
use App\Repositories\UserRepository;
use App\Services\AuthService;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\HttpFoundation\Request;

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
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }
}
