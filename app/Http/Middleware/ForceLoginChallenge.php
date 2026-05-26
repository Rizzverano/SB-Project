<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Filament\Facades\Filament;

class ForceLoginChallenge
{
    public function handle(Request $request, Closure $next)
    {
        if (session('login_needs_challenge')) {

            // prevent authenticated access
            if (Filament::auth()->check()) {
                Filament::auth()->logout();
            }

            // allow login and challenge page while the account is in challenge state
            if (! $request->is('admin/login-challenge') && ! $request->is('admin/login')) {
                return redirect('/admin/login-challenge');
            }
        }

        return $next($request);
    }
}
