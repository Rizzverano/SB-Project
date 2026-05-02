<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use App\Filament\Widgets\RecentLegislativeRecords;
use App\Filament\Widgets\RecentOrdinances;
use Laravel\Fortify\LoginRateLimiter;
use App\Auth\FortifyLoginRateLimiter;
use Illuminate\Cache\RateLimiter as CacheRateLimiter;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(LoginRateLimiter::class, function ($app) {
            return new FortifyLoginRateLimiter(
                $app->make(CacheRateLimiter::class)
            );
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Livewire::component(
        'app.filament.widgets.recent-legislative-records',
        RecentLegislativeRecords::class
    );

        Livewire::component(
            'app.filament.widgets.recent-ordinances',
            RecentOrdinances::class
        );
    }
}
