<?php

namespace App\Http\Controllers;

use App\Mail\UserAccountStatusMail;
use App\Models\AuditLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\MessageBag;
use Throwable;

class LoginOtpController extends Controller
{
    private const MAX_ATTEMPTS = 5;
    private const OTP_TTL_MINUTES = 10;

    public function show()
    {
        if (! session('login_otp_pending_user_id')) {
            return redirect('/admin/login');
        }

        return redirect('/admin/login?otp=1')
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    public function verify(Request $request)
    {
        $userId = session('login_otp_pending_user_id');

        if (! $userId) {
            return redirect('/admin/login');
        }

        $request->validate([
            'otp' => ['required', 'digits:6'],
        ]);

        if (! $this->passesRecaptcha($request)) {
            $this->recordLoginAttempt(
                (string) session('login_otp_email', ''),
                AuditLog::STATUS_FAILED,
                $request,
            );

            return back()->withErrors(new MessageBag([
                'otp' => 'Security verification failed.',
            ]));
        }

        $rateLimitKey = 'login-otp:'.$userId.'|'.$request->ip();

        if (RateLimiter::tooManyAttempts($rateLimitKey, self::MAX_ATTEMPTS)) {
            return back()->withErrors(new MessageBag([
                'otp' => 'Too many OTP attempts. Please wait before trying again.',
            ]));
        }

        if (now()->timestamp > (int) session('login_otp_expires_at')) {
            $user = User::find($userId);

            $this->forgetOtpSession();

            return redirect('/admin/login')->withErrors(new MessageBag([
                'data.email' => 'Your OTP has expired. Please log in again to receive a new code.',
            ]));
        }

        if (! Hash::check((string) $request->otp, (string) session('login_otp_hash'))) {
            RateLimiter::hit($rateLimitKey, 600);

            return back()->withErrors(new MessageBag([
                'otp' => 'The OTP verification code is incorrect.',
            ]));
        }

        $user = User::find($userId);

        if (! $user || ! $user->is_active) {
            $this->forgetOtpSession();

            return redirect('/admin/login')->withErrors(new MessageBag([
                'data.email' => 'Your account is not available.',
            ]));
        }

        RateLimiter::clear($rateLimitKey);

        $remember = (bool) session('login_otp_remember', false);
        $user->forceFill([
            'login_otp_verified_at' => now(),
        ])->save();

        Auth::login($user, $remember);
        session()->regenerate();

        $this->recordLoginAttempt($user->email, AuditLog::STATUS_SUCCESS, $request);
        $this->forgetOtpSession();

        return redirect('/admin/dashboard');
    }

    public static function userNeedsOtp(User $user): bool
    {
        return $user->login_otp_verified_at === null;
    }

    public static function beginChallenge(User $user, bool $remember = false, bool $forceNewCode = false): bool
    {
        if (
            ! $forceNewCode &&
            (int) session('login_otp_pending_user_id') === $user->id &&
            session('login_otp_hash') &&
            now()->timestamp <= (int) session('login_otp_expires_at')
        ) {
            session(['login_otp_remember' => $remember]);

            return true;
        }

        $otp = (string) random_int(100000, 999999);

        try {
            Mail::to($user->email)->send(new UserAccountStatusMail(
                $user->name,
                "Your login OTP verification code is {$otp}. This code will expire in ".self::OTP_TTL_MINUTES.' minutes.',
                'Login OTP Verification',
            ));
        } catch (Throwable $exception) {
            report($exception);

            return false;
        }

        session([
            'login_otp_pending_user_id' => $user->id,
            'login_otp_email' => $user->email,
            'login_otp_hash' => Hash::make($otp),
            'login_otp_expires_at' => now()->addMinutes(self::OTP_TTL_MINUTES)->timestamp,
            'login_otp_remember' => $remember,
        ]);

        return true;
    }

    public function resend(Request $request)
    {
        $userId = session('login_otp_pending_user_id');

        if (! $userId) {
            return redirect('/admin/login');
        }

        $rateLimitKey = 'login-otp-resend:'.$userId.'|'.$request->ip();
        $maxResends = 5;

        if (RateLimiter::tooManyAttempts($rateLimitKey, $maxResends)) {
            $message = 'Too many resend requests. Please wait before trying again.';

            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => $message], 429);
            }

            return back()->withErrors(new MessageBag(['otp' => $message]));
        }

        $user = User::find($userId);

        if (! $user) {
            $this->forgetOtpSession();

            return redirect('/admin/login');
        }

        RateLimiter::hit($rateLimitKey, 3600);

        $sent = self::beginChallenge($user, (bool) session('login_otp_remember', false), true);

        if (! $sent) {
            $message = 'Unable to send OTP right now. Please try again later.';

            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => $message], 500);
            }

            return back()->withErrors(new MessageBag(['otp' => $message]));
        }

        $message = 'A new OTP has been sent to your email.';

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'message' => $message, 'expires_at' => session('login_otp_expires_at')]);
        }

        return back()->with('status', $message);
    }

    protected function forgetOtpSession(): void
    {
        session()->forget([
            'login_otp_pending_user_id',
            'login_otp_email',
            'login_otp_hash',
            'login_otp_expires_at',
            'login_otp_remember',
        ]);
    }

    protected function passesRecaptcha(Request $request): bool
    {
        $secretKey = config('services.recaptcha.secret_key');

        if (! $secretKey) {
            return true;
        }

        $recaptchaToken = $request->input('token');

        if (! $recaptchaToken) {
            return false;
        }

        try {
            $response = Http::asForm()->post(
                'https://www.google.com/recaptcha/api/siteverify',
                [
                    'secret' => $secretKey,
                    'response' => $recaptchaToken,
                    'remoteip' => $request->ip(),
                ]
            )->json();
        } catch (Throwable $exception) {
            report($exception);

            return false;
        }

        return (bool) ($response['success'] ?? false);
    }

    protected function recordLoginAttempt(string $email, string $status, Request $request): void
    {
        AuditLog::create([
            'email' => $email,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'status' => $status,
            'attempted_at' => now(),
            'failure_reason' => null,
            'is_locked' => false,
            'has_challenge' => true,
        ]);
    }
}
