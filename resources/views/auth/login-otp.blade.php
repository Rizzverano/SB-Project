@php
    $email ??= session('login_otp_email');
    $recaptchaSiteKey = config('services.recaptcha.site_key');
@endphp

<style>
    #resend-otp-button {
    font-size: 11px;
    font-weight: 500;
    color: var(--color-text-info, #185fa5);
    background: none;
    border: none;
    padding: 0;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 4px;
    font-family: inherit;
    text-decoration: none;
    }
</style>

<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="otp-modal-backdrop" role="presentation">
    <div class="otp-modal" role="dialog" aria-modal="true" aria-labelledby="login-otp-title">
        <div class="otp-modal-icon">
            <x-heroicon-o-shield-check class="h-6 w-6" />
        </div>

        <div class="otp-modal-eyebrow">
            Two-Factor Authentication
        </div>

        <h2 id="login-otp-title">
            OTP Verification
        </h2>

        <p class="otp-modal-copy">
            Enter the 6-digit code sent to {{ $email }}.
        </p>

        <form method="POST" action="{{ route('login.otp.verify') }}" class="otp-modal-form" id="login-otp-form">
            @csrf

            <div>
                <label for="login-otp-code">Verification Code</label>
                <input
                    id="login-otp-code"
                    type="text"
                    name="otp"
                    maxlength="6"
                    inputmode="numeric"
                    autocomplete="one-time-code"
                    autofocus
                >

                @if($recaptchaSiteKey)
                    <p class="otp-modal-copy" style="font-size:0.75rem; color:#94a3b8; margin-top:0.5rem;">
                        Protected by reCAPTCHA - <a href="https://policies.google.com/privacy" class="underline">Privacy</a> &amp; <a href="https://policies.google.com/terms" class="underline">Terms</a>
                    </p>
                @endif

                @error('otp')
                    <p class="otp-modal-error">{{ $message }}</p>
                @enderror
            </div>

            @if(session('status'))
                <p id="otp-status" class="otp-modal-info">{{ session('status') }}</p>
            @else
                <p id="otp-status" class="otp-modal-info" style="display:none;"></p>
            @endif

            <div style="margin-top:0.5rem; display:flex; gap:0.5rem; align-items:center;">
                <a href="#" id="resend-otp-button">Resend code</a>
                <div id="resend-countdown" style="color:#94a3b8; font-size:0.9rem;"></div>
            </div>

            <input type="hidden" name="token" id="recaptcha-token">

            <button type="submit" id="verify-otp-button">
                Verify and Continue
            </button>
        </form>
    </div>
</div>

<script>
    history.replaceState(null, '', @js(route('filament.admin.auth.login', ['otp' => 1])));

    window.addEventListener('pageshow', function (event) {
        if (event.persisted) {
            window.location.reload();
        }
    });
</script>

@if($recaptchaSiteKey)
    <script src="https://www.google.com/recaptcha/api.js?render={{ $recaptchaSiteKey }}"></script>
@endif

<script>
    (function () {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const otpForm = document.getElementById('login-otp-form');
        const otpInput = document.getElementById('login-otp-code');
        const verifyButton = document.getElementById('verify-otp-button');
        const recaptchaToken = document.getElementById('recaptcha-token');
        const resendButton = document.getElementById('resend-otp-button');
        const countdownEl = document.getElementById('resend-countdown');
        const statusEl = document.getElementById('otp-status');
        const recaptchaSiteKey = @json($recaptchaSiteKey);

        let expiresAt = @json(session('login_otp_expires_at')) || null;
        if (expiresAt) {
            expiresAt = parseInt(expiresAt, 10) * 1000;
        }

        let manualCooldown = false;
        let isSubmitting = false;

        function formatTime(seconds) {
            if (seconds <= 0) return '00s';
            return seconds + 's';
        }

        function setStatus(message) {
            if (!statusEl) return;
            statusEl.textContent = message;
            statusEl.style.display = 'block';
        }

        function updateCountdown() {
            if (!countdownEl || !expiresAt) {
                if (countdownEl) countdownEl.textContent = '';
                return;
            }

            const remaining = Math.max(0, Math.ceil((expiresAt - Date.now()) / 1000));
            countdownEl.textContent = remaining > 0
                ? 'Resend in ' + formatTime(remaining)
                : 'Code expired. Please resend.';
        }

        function unlockResendAfterDelay() {
            setTimeout(function () {
                manualCooldown = false;
                resendButton.disabled = false;
            }, 30000);
        }

        function sendResend() {
            if (manualCooldown) return;

            manualCooldown = true;
            resendButton.disabled = true;

            fetch("{{ route('login.otp.resend') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({}),
            }).then(function (res) {
                return res.json().catch(function () { return { success: false }; });
            }).then(function (json) {
                if (json && json.success) {
                    setStatus(json.message || 'A new OTP was sent.');
                    if (json.expires_at) {
                        expiresAt = parseInt(json.expires_at, 10) * 1000;
                    }
                } else {
                    setStatus(json.message || 'Unable to resend OTP.');
                }

                unlockResendAfterDelay();
            }).catch(function () {
                setStatus('Unable to resend OTP.');
                unlockResendAfterDelay();
            });
        }

        function submitOtpForm() {
            if (!recaptchaSiteKey) {
                otpForm.submit();
                return;
            }

            if (!window.grecaptcha) {
                setStatus('Security verification is still loading. Please try again.');
                verifyButton.disabled = false;
                isSubmitting = false;
                return;
            }

            grecaptcha.ready(function () {
                grecaptcha.execute(recaptchaSiteKey, { action: 'login_otp_verify' })
                    .then(function (token) {
                        recaptchaToken.value = token;
                        otpForm.submit();
                    })
                    .catch(function () {
                        setStatus('Security verification failed. Please try again.');
                        verifyButton.disabled = false;
                        isSubmitting = false;
                    });
            });
        }

        if (otpForm) {
            otpForm.addEventListener('submit', function (event) {
                if (isSubmitting) {
                    return;
                }

                event.preventDefault();

                const otp = (otpInput.value || '').trim();

                if (!/^\d{6}$/.test(otp)) {
                    setStatus('Please enter the 6-digit OTP code.');
                    otpInput.focus();
                    return;
                }

                isSubmitting = true;
                verifyButton.disabled = true;
                submitOtpForm();
            });
        }

        if (resendButton) {
            resendButton.addEventListener('click', function (event) {
                event.preventDefault();
                sendResend();
            });
        }

        setInterval(updateCountdown, 1000);
        updateCountdown();
    })();
</script>
