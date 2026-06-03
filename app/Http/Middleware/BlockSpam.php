<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\BlockedEmail;
use App\Models\BlockedIp;
use Illuminate\Support\Str;

class BlockSpam
{
    public function handle($request, Closure $next)
    {
        if (BlockedIp::where('ip_address', $request->ip())->exists()) {
            abort(403, 'Your device is blocked.');
        }

        $email = $request->input('email');
        if ($email && BlockedEmail::where('email', Str::lower(trim($email)))->exists()) {
            abort(403, 'Your email is blocked.');
        }

        return $next($request);
    }
}
