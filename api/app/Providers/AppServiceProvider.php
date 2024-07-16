<?php

namespace App\Providers;

use App\Contracts\Repositories\ItemRepositoryContract;
use App\Contracts\Repositories\OrderRepositoryContract;
use App\Contracts\Repositories\RestaurantRepositoryContract;
use App\Contracts\Repositories\TableRepositoryContract;
use App\Contracts\Repositories\UserRepositoryContract;
use App\Contracts\Services\AuthServiceContract;
use App\Http\Resources\ItemCollection;
use App\Http\Resources\ItemResource;
use App\Http\Resources\OrderCollection;
use App\Http\Resources\OrderResource;
use App\Http\Resources\RestaurantCollection;
use App\Http\Resources\RestaurantResource;
use App\Http\Resources\TableCollection;
use App\Http\Resources\TableResource;
use App\Models\Order;
use App\Observers\OrderObserver;
use App\Repositories\ItemRepository;
use App\Repositories\OrderRepository;
use App\Repositories\RestaurantRepository;
use App\Repositories\TableRepository;
use App\Repositories\UserRepository;
use App\Services\AuthService;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Request;

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

        $this->app->bind(RestaurantCollection::class, function () {
            return new RestaurantCollection();
        });

        $this->app->bind(RestaurantResource::class, function () {
            return new RestaurantResource();
        });

        $this->app->bind(TableCollection::class, function () {
            return new TableCollection();
        });

        $this->app->bind(TableResource::class, function () {
            return new TableResource();
        });

        $this->app->bind(ItemCollection::class, function () {
            return new ItemCollection();
        });

        $this->app->bind(ItemResource::class, function () {
            return new ItemResource();
        });

        $this->app->bind(OrderCollection::class, function () {
            return new OrderCollection();
        });

        $this->app->bind(OrderResource::class, function () {
            return new OrderResource();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        Order::observe(OrderObserver::class);
    }
}
