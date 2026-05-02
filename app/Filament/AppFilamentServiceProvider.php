<?php

namespace App\Filament;

use Illuminate\Support\ServiceProvider;

class AppFilamentServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Filament 3 auto-discovers resources from App\Filament\Resources
        // No additional configuration needed
    }
}