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
            return response()->view('errors.blocked', [], 403);
        }

        $email = $request->input('email');

        if (
            $email &&
            BlockedEmail::where('email', Str::lower(trim($email)))->exists()
        ) {
            return response()->view('errors.blocked', [], 403);
        }

        return $next($request);
    }
}
