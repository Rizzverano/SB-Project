<?php

namespace App\Http\Middleware;

use Closure;
use Filament\Facades\Filament;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HideNotificationsForMembers
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && ! auth()->user()->isAdmin()) {
            Filament::setCurrentPanel(
                Filament::getPanel('admin')
                    ->databaseNotifications(false)
            );
        }

        return $next($request);
    }
}
