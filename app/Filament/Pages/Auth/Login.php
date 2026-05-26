<?php

namespace App\Filament\Pages\Auth;

use App\Auth\FortifyLoginRateLimiter;
use App\Http\Controllers\LoginOtpController;
use App\Models\AuditLog;
use App\Models\User;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use Filament\Facades\Filament;
use Filament\Http\Responses\Auth\Contracts\LoginResponse;
use Filament\Models\Contracts\FilamentUser;
use Filament\Pages\Auth\Login as BaseLogin;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Throwable;

class Login extends BaseLogin
{
    protected static string $view = 'filament.pages.auth.login';

    protected static ?string $title = null;

    public function authenticate(): ?LoginResponse
    {
        $data = $this->form->getState();
        $email = (string) ($data['email'] ?? '');

        try {
            /** @var FortifyLoginRateLimiter $loginRateLimiter */
            $loginRateLimiter = app(FortifyLoginRateLimiter::class);

            request()->merge([
                'email' => $email,
            ]);

            $lockoutUntil = session('login_lockout_until');

            if ($lockoutUntil) {

                if (now()->timestamp < $lockoutUntil) {
                    $seconds = $lockoutUntil - now()->timestamp;

                    $this->recordLoginAttempt(
                        $email,
                        AuditLog::STATUS_FAILED,
                        'locked',
                        true,
                        true,
                    );

                    $this->resetForm($data);

                    throw ValidationException::withMessages([
                        'data.email' => "Too many failed attempts. Account locked for {$seconds} seconds.",
                    ]);
                }

                // lock expired — allow the user to retry credentials.
                session()->forget('login_lockout_until');
            }

            if ($loginRateLimiter->tooManyAttempts(request())) {
                $seconds = $loginRateLimiter->availableIn(request());

                $this->resetForm($data);

                $this->rememberChallengeLockout($email, $seconds);

                $this->recordLoginAttempt(
                    $email,
                    AuditLog::STATUS_FAILED,
                    'locked',
                    true,
                    true,
                );

                throw ValidationException::withMessages([
                    'data.email' => "Too many failed attempts. Account locked for {$seconds} seconds.",
                ]);
            }

            if (! Filament::auth()->attempt(
                $this->getCredentialsFromFormData($data),
                $data['remember'] ?? false
            )) {

                $loginRateLimiter->increment(request());

                $attempts = $loginRateLimiter->attempts(request());
                $maxAttempts = FortifyLoginRateLimiter::MAX_ATTEMPTS;
                $remaining = max(0, $maxAttempts - $attempts);
                $isLocked = $attempts >= $maxAttempts;
                $failureReason = User::where('email', $email)->exists()
                    ? 'wrong_password'
                    : 'user_not_found';

                $this->resetForm($data);

                if ($isLocked) {
                    $seconds = $loginRateLimiter->availableIn(request());

                    $this->rememberChallengeLockout($email, $seconds);

                    $this->recordLoginAttempt(
                        $email,
                        AuditLog::STATUS_FAILED,
                        $failureReason,
                        true,
                        true,
                    );

                    throw ValidationException::withMessages([
                        'data.email' => "Too many failed attempts. Account locked for {$seconds} seconds.",
                    ]);
                }

                $this->recordLoginAttempt(
                    $email,
                    AuditLog::STATUS_FAILED,
                    $failureReason,
                );

                throw ValidationException::withMessages([
                    'data.email' => "Invalid credentials. {$remaining} attempt(s) remaining.",
                ]);
            }

            $user = Filament::auth()->user();
            $challengeEmail = session('login_challenge_email');
            $loginNeedsChallenge = session('login_needs_challenge');

            if ($loginNeedsChallenge && $challengeEmail === $email) {
                Filament::auth()->logout();

                $this->redirect('/admin/login-challenge');

                return null;
            }

            if ($loginNeedsChallenge && $challengeEmail !== null && $challengeEmail !== $email) {
                session()->forget([
                    'login_needs_challenge',
                    'login_challenge_email',
                    'login_lockout_until',
                ]);
            }

            if (
                $user instanceof FilamentUser &&
                ! $user->canAccessPanel(Filament::getCurrentPanel())
            ) {
                Filament::auth()->logout();
                $loginRateLimiter->increment(request());

                $attempts = $loginRateLimiter->attempts(request());
                $isLocked = $attempts >= FortifyLoginRateLimiter::MAX_ATTEMPTS;

                if ($isLocked) {
                    $seconds = $loginRateLimiter->availableIn(request());
                    $this->rememberChallengeLockout($email, $seconds);
                }

                $this->recordLoginAttempt(
                    $email,
                    AuditLog::STATUS_FAILED,
                    'unauthorized_panel',
                    $isLocked,
                    $isLocked,
                );

                throw ValidationException::withMessages([
                    'data.email' => 'You are not authorized to access this panel.',
                ]);
            }

            $loginRateLimiter->clear(request());

            if (LoginOtpController::userNeedsOtp($user)) {
                $remember = (bool) ($data['remember'] ?? false);

                if (! LoginOtpController::beginChallenge($user, $remember)) {
                    Filament::auth()->logout();

                    throw ValidationException::withMessages([
                        'data.email' => 'Login OTP could not be sent. Please try again later.',
                    ]);
                }

                Filament::auth()->logout();

                $this->redirect('/admin/login?otp=1');

                return null;
            }

            session()->regenerate();

            $this->recordLoginAttempt($email, AuditLog::STATUS_SUCCESS);

            return app(LoginResponse::class);

        } catch (ValidationException $e) {
            throw $e;
        } catch (TooManyRequestsException $e) {
            throw ValidationException::withMessages([
                'data.email' => 'Too many requests. Please wait and try again.',
            ]);

        } catch (Throwable $e) {
            Log::error('Login error: '.$e->getMessage());

            throw ValidationException::withMessages([
                'data.email' => 'Something went wrong. Please try again later.',
            ]);
        }
    }

    protected function resetForm(array $data): void
    {
        $this->form->fill([
            'email' => $data['email'] ?? '',
            'password' => '',
            'remember' => $data['remember'] ?? false,
        ]);
    }

    protected function rememberChallengeLockout(string $email, int $seconds): void
    {
        session([
            'login_needs_challenge' => true,
            'login_challenge_email' => $email,
            'login_lockout_until' => now()->addSeconds($seconds)->timestamp,
        ]);
    }

    protected function recordLoginAttempt(
        string $email,
        string $status,
        ?string $failureReason = null,
        bool $isLocked = false,
        bool $hasChallenge = false,
    ): void {
        AuditLog::create([
            'email' => $email,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'status' => $status,
            'attempted_at' => now(),
            'failure_reason' => $failureReason,
            'is_locked' => $isLocked,
            'has_challenge' => $hasChallenge,
        ]);
    }
}
