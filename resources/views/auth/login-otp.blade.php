@php
    $email ??= session('login_otp_email');
@endphp

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

        <form method="POST" action="{{ route('login.otp.verify') }}" class="otp-modal-form">
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

                <p class="otp-modal-copy" style="font-size:0.75rem; color:#94a3b8; margin-top:0.5rem;">
                    Protected by reCAPTCHA — <a href="https://policies.google.com/privacy" class="underline">Privacy</a> &amp; <a href="https://policies.google.com/terms" class="underline">Terms</a>
                </p>

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
                <form method="POST" action="{{ route('login.otp.resend') }}" id="resend-otp-form">
                    @csrf
                    <button type="submit" id="resend-otp-button">Resend code</button>
                </form>
                <div id="resend-countdown" style="color:#94a3b8; font-size:0.9rem;"></div>
            </div>

            <input type="hidden" name="token" id="recaptcha-token">

            <button type="submit">
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
<script src="https://www.google.com/recaptcha/api.js?render={{ config('services.recaptcha.site_key') }}"></script>
<script>
    grecaptcha.ready(function () {
        grecaptcha.execute("{{ config('services.recaptcha.site_key') }}", {action:'login'})
            .then(function(token) {
                document.getElementById('recaptcha-token').value = token;
            });
    });
</script>
<script>
    (function () {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const resendButton = document.getElementById('resend-otp-button');
        const resendForm = document.getElementById('resend-otp-form');
        const countdownEl = document.getElementById('resend-countdown');
        const statusEl = document.getElementById('otp-status');

        let expiresAt = @json(session('login_otp_expires_at')) || null;
        if (expiresAt) {
            expiresAt = parseInt(expiresAt, 10) * 1000; // convert seconds -> ms
        }

        let autoResent = false;
        let manualCooldown = false;

        function formatTime(s) {
            if (s <= 0) return '00s';
            return s + 's';
        }

        function updateCountdown() {
            if (!expiresAt) {
                countdownEl.textContent = '';
                return;
            }

            const remaining = Math.max(0, Math.ceil((expiresAt - Date.now()) / 1000));

            if (remaining > 0) {
                countdownEl.textContent = 'Resend in ' + formatTime(remaining);
            } else {
                countdownEl.textContent = 'Code expired — requesting a new one...';

                if (!autoResent) {
                    autoResent = true;
                    sendResend();
                }
            }
        }

        function setStatus(message) {
            if (!statusEl) return;
            statusEl.textContent = message;
            statusEl.style.display = 'block';
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

                // re-enable after 30s
                setTimeout(function () {
                    manualCooldown = false;
                    resendButton.disabled = false;
                }, 30000);
            }).catch(function () {
                setStatus('Unable to resend OTP.');
                setTimeout(function () {
                    manualCooldown = false;
                    resendButton.disabled = false;
                }, 30000);
            });
        }

        // intercept manual form submit to use AJAX
        if (resendForm) {
            resendForm.addEventListener('submit', function (e) {
                e.preventDefault();
                if (manualCooldown) return;
                autoResent = true; // avoid duplicate auto
                sendResend();
            });
        }

        // start countdown timer
        setInterval(updateCountdown, 1000);
        updateCountdown();
    })();
</script>
