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

                @error('otp')
                    <p class="otp-modal-error">{{ $message }}</p>
                @enderror
            </div>

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
