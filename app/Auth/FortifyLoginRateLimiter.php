<?php

namespace App\Auth;

use Illuminate\Http\Request;
use Laravel\Fortify\LoginRateLimiter;

class FortifyLoginRateLimiter extends LoginRateLimiter
{
    public const MAX_ATTEMPTS = 3;
    public const DECAY_SECONDS = 60;

    public function tooManyAttempts(Request $request): bool
    {
        return $this->limiter->tooManyAttempts(
            $this->throttleKey($request),
            self::MAX_ATTEMPTS
        );
    }

    public function increment(Request $request, ?int $decaySeconds = null): void
    {
        $this->limiter->hit(
            $this->throttleKey($request),
            $decaySeconds ?? self::DECAY_SECONDS
        );
    }

    public function clear(Request $request): void
    {
        $this->limiter->clear($this->throttleKey($request));
    }

    public function availableIn(Request $request): int
    {
        return $this->limiter->availableIn($this->throttleKey($request));
    }

    public function attempts(Request $request)
    {
        return $this->limiter->attempts($this->throttleKey($request));
    }

    protected function throttleKey(Request $request): string
    {
        return sha1(
            $request->input('email') . '|' . $request->ip()
        );
    }
}
