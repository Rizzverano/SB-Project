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

            // block all admin access except challenge page
            if (! $request->is('admin/login-challenge')) {
                return redirect('/admin/login-challenge');
            }
        }

        return $next($request);
    }
}
