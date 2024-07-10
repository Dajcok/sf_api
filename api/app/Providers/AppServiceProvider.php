<?php

namespace App\Providers;

use app\Contracts\Repositories\RepositoryContract;
use app\Contracts\Repositories\UserRepositoryContract;
use app\Contracts\Services\AuthServiceContract;
use App\Contracts\Services\UserServiceContract;
use App\Repositories\UserRepository;
use App\Services\AuthService;
use App\Services\UserService;
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
            UserServiceContract::class,
            UserService::class
        );

        $this->app->bind(
            AuthServiceContract::class,
            AuthService::class
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
