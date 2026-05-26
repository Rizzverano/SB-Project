<?php

namespace App\Http\Controllers;

use App\Auth\FortifyLoginRateLimiter;
use App\Models\AuditLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\MessageBag;

class LoginChallengeController extends Controller
{
    private const MAX_CHALLENGE_ATTEMPTS = 3;

    public function show()
    {
        if (! session('login_needs_challenge')) {
            return redirect('/admin/login');
        }

        $lockoutUntil = session('login_lockout_until');

        if ($lockoutUntil) {

            if (now()->timestamp < $lockoutUntil) {
                $seconds = $lockoutUntil - now()->timestamp;

                return redirect('/admin/login')->withErrors([
                    'data.email' => "Too many failed attempts. Account locked for {$seconds} seconds.",
                ]);
            }

            session()->forget('login_lockout_until');
        }

        if (! session()->has('challenge_answer')) {
            $num1 = rand(1, 9);
            $num2 = rand(1, 9);

            session([
                'challenge_num1' => $num1,
                'challenge_num2' => $num2,
                'challenge_answer' => "x = " . $num1 . $num2,
            ]);
        }

        return response()
            ->view('auth.login-challenge', [
                'num1' => session('challenge_num1'),
                'num2' => session('challenge_num2'),
            ])
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    public function verify(Request $request)
    {
        if (! session('login_needs_challenge')) {
            return redirect('/admin/login');
        }

        $request->validate([
            'answer' => 'required',
            'token' => 'required',
        ]);

        $response = Http::asForm()->post(
            'https://www.google.com/recaptcha/api/siteverify',
            [
                'secret' => config('services.recaptcha.secret_key'),
                'response' => $request->token,
                'remoteip' => $request->ip(),
            ]
        )->json();

        if (! ($response['success'] ?? false)) {
            $this->recordLoginAttempt(
                (string) session('login_challenge_email', ''),
                AuditLog::STATUS_FAILED,
                'challenge_verification_failed',
                false,
                true,
                $request,
            );

            return back()->withErrors([
                'answer' => 'Security verification failed.',
            ]);
        }

        $expected = (string) session('challenge_answer');
        $answer = (string) $request->answer;

        if (! $this->challengeAnswerMatches($answer, $expected)) {
            $failedAttempts = (int) session('login_challenge_failed_attempts', 0) + 1;

            session(['login_challenge_failed_attempts' => $failedAttempts]);

            if ($failedAttempts >= self::MAX_CHALLENGE_ATTEMPTS) {

                $seconds = $this->triggerLoginLockout($request);
                $email = (string) session('login_challenge_email', '');

                session()->forget([
                    'challenge_num1',
                    'challenge_num2',
                    'challenge_answer',
                    'login_challenge_failed_attempts',
                ]);

                session([
                    'login_needs_challenge' => true,
                    'login_lockout_until' => now()->addSeconds($seconds)->timestamp,
                ]);

                $this->recordLoginAttempt(
                    $email,
                    AuditLog::STATUS_FAILED,
                    'wrong_challenge',
                    true,
                    true,
                    $request,
                );

                return redirect('/admin/login')->withErrors(new MessageBag([
                    'data.email' => "Too many failed attempts. Account locked for {$seconds} seconds.",
                ]));
            }

            $remaining = self::MAX_CHALLENGE_ATTEMPTS - $failedAttempts;

            $this->recordLoginAttempt(
                (string) session('login_challenge_email', ''),
                AuditLog::STATUS_FAILED,
                'wrong_challenge',
                false,
                true,
                $request,
            );

            return back()->withErrors([
                'answer' => "Incorrect answer. {$remaining} attempt(s) remaining.",
            ]);
        }

        $email = session('login_challenge_email');

        session()->forget([
            'login_needs_challenge',
            'login_lockout_until',
            'challenge_num1',
            'challenge_num2',
            'challenge_answer',
            'login_challenge_failed_attempts',
        ]);

        if ($email) {
            $user = User::where('email', $email)->first();

            if ($user) {
                Auth::login($user);
                session()->regenerate();

                $this->recordLoginAttempt(
                    $email,
                    AuditLog::STATUS_SUCCESS,
                    null,
                    false,
                    true,
                    $request,
                );

                return redirect('/admin/dashboard');
            }
        }

        $this->recordLoginAttempt(
            (string) $email,
            AuditLog::STATUS_FAILED,
            'user_not_found',
            false,
            true,
            $request,
        );

        return redirect('/admin/login');
    }

    protected function challengeAnswerMatches(string $answer, string $expected): bool
    {
        $normalize = static fn (string $value): string => strtolower(preg_replace('/\s+/', '', trim($value)));

        return $normalize($answer) === $normalize($expected);
    }

    protected function triggerLoginLockout(Request $request): int
    {
        $email = (string) session('login_challenge_email', '');

        $rateLimitRequest = Request::create('/admin/login', 'POST', [
            'email' => $email,
        ]);

        $rateLimitRequest->server->set('REMOTE_ADDR', $request->ip());

        /** @var FortifyLoginRateLimiter $loginRateLimiter */
        $loginRateLimiter = app(FortifyLoginRateLimiter::class);

        while (! $loginRateLimiter->tooManyAttempts($rateLimitRequest)) {
            $loginRateLimiter->increment($rateLimitRequest);
        }

        return $loginRateLimiter->availableIn($rateLimitRequest);
    }

    protected function recordLoginAttempt(
        string $email,
        string $status,
        ?string $failureReason,
        bool $isLocked,
        bool $hasChallenge,
        Request $request,
    ): void {
        AuditLog::create([
            'email' => $email,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'status' => $status,
            'attempted_at' => now(),
            'failure_reason' => $failureReason,
            'is_locked' => $isLocked,
            'has_challenge' => $hasChallenge,
        ]);
    }
}
