<?php

namespace App\Providers;

use App\Repositories\Contracts\{UserRepositoryInterface, CarRepositoryInterface, RentRepositoryInterface};
use App\Repositories\Eloquent\{CarEloquentORM, RentEloquentORM, UserEloquentORM};
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            CarRepositoryInterface::class,
            CarEloquentORM::class
        );

        $this->app->bind(
            UserRepositoryInterface::class,
            UserEloquentORM::class
        );;

        $this->app->bind(
            RentRepositoryInterface::class,
            RentEloquentORM::class
        );;
    }
}
