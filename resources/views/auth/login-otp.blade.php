@php
    $email ??= session('login_otp_email');
@endphp

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
