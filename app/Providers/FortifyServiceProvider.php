<?php

namespace App\Providers;

use App\Auth\FortifyLoginRateLimiter;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;
use Laravel\Fortify\LoginRateLimiter;

class FortifyServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        Fortify::ignoreRoutes();

        $this->app->singleton(LoginRateLimiter::class, FortifyLoginRateLimiter::class);
    }

    public function boot(): void
    {
        //
    }
}
