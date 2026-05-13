<?php

namespace App\Http\Middleware;

use App\Http\Controllers\LoginOtpController;
use Closure;
use Filament\Facades\Filament;
use Illuminate\Http\Request;

class EnsureLoginOtpIsVerified
{
    public function handle(Request $request, Closure $next)
    {
        $user = Filament::auth()->user();

        if (
            $user &&
            ! $request->is('admin/login-otp') &&
            LoginOtpController::userNeedsOtp($user)
        ) {
            if (! LoginOtpController::beginChallenge($user, false)) {
                Filament::auth()->logout();

                return redirect('/admin/login')->withErrors([
                    'data.email' => 'Login OTP could not be sent. Please try again later.',
                ]);
            }

            Filament::auth()->logout();

            return redirect('/admin/login?otp=1');
        }

        return $next($request);
    }
}
