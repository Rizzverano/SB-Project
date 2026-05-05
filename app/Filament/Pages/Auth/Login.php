<?php

namespace App\Filament\Pages\Auth;

use App\Auth\FortifyLoginRateLimiter;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use Filament\Facades\Filament;
use Filament\Http\Responses\Auth\Contracts\LoginResponse;
use Filament\Models\Contracts\FilamentUser;
use Filament\Pages\Auth\Login as BaseLogin;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Throwable;

class Login extends BaseLogin
{
    protected static string $view = 'filament.pages.auth.login';
    protected static ?string $title = null;

    public function authenticate(): ?LoginResponse
    {
        $data = $this->form->getState();

        try {
            /** @var FortifyLoginRateLimiter $loginRateLimiter */
            $loginRateLimiter = app(FortifyLoginRateLimiter::class);

            request()->merge([
                'email' => $data['email'] ?? '',
            ]);

            $lockoutUntil = session('login_lockout_until');

            if ($lockoutUntil) {

                if (now()->timestamp < $lockoutUntil) {
                    $seconds = $lockoutUntil - now()->timestamp;

                    $this->resetForm($data);

                    throw ValidationException::withMessages([
                        'data.email' =>
                            "Too many failed attempts. Account locked for {$seconds} seconds.",
                    ]);
                }

                // lock expired → go to challenge
                session()->forget('login_lockout_until');

                throw new HttpResponseException(
                    redirect('/admin/login-challenge')
                );
            }

            if ($loginRateLimiter->tooManyAttempts(request())) {
                $seconds = $loginRateLimiter->availableIn(request());

                $this->resetForm($data);

                $this->rememberChallengeLockout($data['email'] ?? '', $seconds);

                throw ValidationException::withMessages([
                    'data.email' =>
                        "Too many failed attempts. Account locked for {$seconds} seconds.",
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

                $this->resetForm($data);

                if ($attempts >= $maxAttempts) {
                    $seconds = $loginRateLimiter->availableIn(request());

                    $this->rememberChallengeLockout($data['email'] ?? '', $seconds);

                    throw ValidationException::withMessages([
                        'data.email' =>
                            "Too many failed attempts. Account locked for {$seconds} seconds.",
                    ]);
                }

                throw ValidationException::withMessages([
                    'data.email' =>
                        "Invalid credentials. {$remaining} attempt(s) remaining.",
                ]);
            }

            $user = Filament::auth()->user();

            if (
                $user instanceof FilamentUser &&
                ! $user->canAccessPanel(Filament::getCurrentPanel())
            ) {
                Filament::auth()->logout();
                $loginRateLimiter->increment(request());

                throw ValidationException::withMessages([
                    'data.email' => 'You are not authorized to access this panel.',
                ]);
            }

            $loginRateLimiter->clear(request());
            session()->regenerate();

            return app(LoginResponse::class);

        } catch (ValidationException $e) {
            throw $e;

        } catch (TooManyRequestsException $e) {
            throw ValidationException::withMessages([
                'data.email' => 'Too many requests. Please wait and try again.',
            ]);

        } catch (Throwable $e) {
            Log::error('Login error: ' . $e->getMessage());

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
}
