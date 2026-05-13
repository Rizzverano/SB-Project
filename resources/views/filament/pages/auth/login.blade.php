{{-- resources/views/filament/pages/auth/login.blade.php --}}

@php
    $activeLogo = \App\Models\Logo::published()->latest()->first();
    $lockoutUntil = session('login_lockout_until');
    $initialLockoutSeconds = $lockoutUntil ? max(0, $lockoutUntil - now()->timestamp) : 0;
    $shouldRedirectToChallenge = session('login_needs_challenge') && (! $lockoutUntil || now()->timestamp >= $lockoutUntil);
    $showLoginOtpModal = session()->has('login_otp_pending_user_id');
@endphp

<x-filament-panels::page.simple>
    <style>
        body {
            background:
                radial-gradient(circle at top left, rgba(59, 130, 246, 0.18), transparent 28%),
                radial-gradient(circle at top right, rgba(16, 185, 129, 0.14), transparent 32%),
                linear-gradient(180deg, #0f172a 0%, #111827 46%, #0b1220 100%) !important;
            font-family: 'Segoe UI', sans-serif;
            letter-spacing: 0.2px;
            color: #e5e7eb;
        }

        .fi-simple-main {
            background: transparent !important;
            box-shadow: none !important;
            padding: 0 !important;
            max-width: 100% !important;
            width: 100% !important;
            margin-top: 0 !important;
            padding-top: 0 !important;
        }

        .fi-simple-layout {
            padding: 0 !important;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .fi-simple-header {
            display: none !important;
        }

        .login-header {
            background: rgba(15, 23, 42, 0.84);
            backdrop-filter: blur(18px);
            border-bottom: 1px solid rgba(148, 163, 184, 0.14);
            padding: 24px 36px 20px;
        }

        .header-inner {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .logo-left,
        .logo-circle {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .logo-square,
        .logo-circle {
            width: 58px;
            height: 58px;
            border: 1px solid rgba(148, 163, 184, 0.18);
            background: rgb(235, 235, 235);
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.04);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #cbd5e1;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            overflow: hidden;
            border-radius: 50%;
        }

        .logo-square img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .header-text {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            text-align: center;
        }

        .header-text .ht-top {
            font-size: 11px;
            color: #94a3b8;
            letter-spacing: 0.12em;
            text-transform: uppercase;
        }

        .header-text .ht-main {
            font-size: 22px;
            font-weight: 800;
            color: #f8fafc;
        }

        .header-text .ht-sub {
            font-size: 12px;
            font-weight: 700;
            color: #34d399;
            letter-spacing: 0.08em;
        }

        .login-body {
            flex: 1;
            display: flex;
            min-height: calc(100vh - 92px);
        }

        .left-panel {
            flex: 1;
            padding: 60px;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            position: relative;
            background:
                radial-gradient(circle at top left, rgba(59, 130, 246, 0.14), transparent 28%),
                linear-gradient(180deg, rgba(15, 23, 42, 0.68), rgba(2, 6, 23, 0.95)),
                linear-gradient(135deg, rgba(16, 185, 129, 0.08), transparent 42%);
            border-right: 1px solid rgba(148, 163, 184, 0.08);
        }

        .left-panel::after {
            content: '';
            position: absolute;
            inset: 0;
            background:
                linear-gradient(0deg, rgba(15, 23, 42, 0.58), rgba(15, 23, 42, 0.1)),
                radial-gradient(circle at 20% 40%, rgba(16, 185, 129, 0.08), transparent 45%);
        }

        .left-tag {
            font-size: 11px;
            letter-spacing: 0.2em;
            color: #60a5fa;
            margin-bottom: 20px;
            text-transform: uppercase;
            position: relative;
            z-index: 1;
        }

        .left-card {
            background: rgba(15, 23, 42, 0.72);
            border: 1px solid rgba(148, 163, 184, 0.12);
            border-radius: 24px;
            padding: 40px;
            backdrop-filter: blur(12px);
            position: relative;
            z-index: 1;
            max-width: 620px;
            box-shadow: 0 24px 80px rgba(2, 6, 23, 0.35);
        }

        .left-card h2 {
            font-size: 36px;
            font-weight: 800;
            color: #f8fafc;
            margin-bottom: 18px;
            line-height: 1.12;
        }

        .left-card p {
            color: #cbd5e1;
            line-height: 1.75;
            max-width: 52ch;
        }

        .left-grid {
            margin-top: 24px;
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 14px;
        }

        .left-metric {
            border-radius: 16px;
            border: 1px solid rgba(148, 163, 184, 0.1);
            background: rgba(255, 255, 255, 0.04);
            padding: 14px 16px;
        }

        .metric-label {
            font-size: 11px;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: #94a3b8;
        }

        .metric-value {
            margin-top: 8px;
            color: #f8fafc;
            font-size: 15px;
            font-weight: 700;
        }

        .right-panel {
            width: 460px;
            background: linear-gradient(180deg, rgba(15, 23, 42, 0.9), rgba(15, 23, 42, 0.98));
            border-left: 1px solid rgba(148, 163, 184, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
        }

        .right-inner {
            width: 100%;
            max-width: 380px;
            padding: 34px 32px;
            border-radius: 24px;
            background: rgba(15, 23, 42, 0.78);
            border: 1px solid rgba(148, 163, 184, 0.12);
            box-shadow: 0 24px 80px rgba(2, 6, 23, 0.42);
        }

        .right-eyebrow {
            font-size: 11px;
            letter-spacing: 0.2em;
            color: #60a5fa;
            text-transform: uppercase;
        }

        .right-inner h1 {
            font-size: 30px;
            font-weight: 800;
            color: #f8fafc;
            margin-top: 6px;
            line-height: 1.15;
        }

        .subtitle {
            color: #cbd5e1;
            margin: 10px 0 24px;
        }

        .notice-box {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.12), rgba(16, 185, 129, 0.1));
            border: 1px solid rgba(59, 130, 246, 0.18);
            border-left: 4px solid #3b82f6;
            padding: 13px 16px;
            border-radius: 12px;
            color: #e2e8f0;
            font-size: 13px;
            margin-bottom: 26px;
        }

        .lockout-alert {
            background: rgba(127, 29, 29, 0.28);
            border: 1px solid rgba(248, 113, 113, 0.3);
            border-left: 4px solid #ef4444;
            padding: 13px 16px;
            border-radius: 12px;
            color: #fecaca;
            font-size: 13px;
            margin-bottom: 22px;
        }

        .right-inner input {
            background: rgba(2, 6, 23, 0.72) !important;
            border: 1px solid rgba(71, 85, 105, 0.7) !important;
            color: #f8fafc !important;
            border-radius: 14px !important;
            transition: 0.2s ease;
        }

        .right-inner input::placeholder {
            color: #94a3b8 !important;
        }

        .right-inner input:focus {
            border-color: #10b981 !important;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.18) !important;
        }

        .right-inner [class*="validation"],
        .right-inner [class*="error"],
        .right-inner .fi-fo-field-wrp-error-message,
        .right-inner p.text-danger,
        .right-inner .text-red-600,
        .right-inner .text-red-500,
        .right-inner [class*="fi-fo-field-wrp"] p,
        .right-inner ul[class*="error"] li {
            color: #f87171 !important;
        }

        .right-inner [class*="fi-fo-field-wrp-error"] input,
        .right-inner input[class*="error"],
        .right-inner input.border-red-500,
        .right-inner input.border-danger {
            border-color: #ef4444 !important;
            box-shadow: 0 0 0 2px rgba(239, 68, 68, 0.2) !important;
        }

        .right-inner label,
        .right-inner .fi-fo-field-wrp label,
        .right-inner [class*="label"],
        .right-inner p,
        .right-inner span {
            color: #f8fafc !important;
        }

        .right-inner .fi-checkbox-label,
        .right-inner [class*="checkbox"] label,
        .right-inner [class*="remember"] label,
        .right-inner input[type="checkbox"]+label,
        .right-inner input[type="checkbox"]~span {
            color: #f8fafc !important;
        }

        .right-inner input[type="checkbox"],
        .right-inner .fi-checkbox-input {
            appearance: none !important;
            -webkit-appearance: none !important;
            width: 18px !important;
            height: 18px !important;
            border-radius: 6px !important;
            border: 2px solid #3b82f6 !important;
            background: transparent !important;
            cursor: pointer !important;
            transition: all 0.2s ease !important;
            flex-shrink: 0 !important;
        }

        .right-inner input[type="checkbox"]:checked,
        .right-inner .fi-checkbox-input:checked {
            background: linear-gradient(135deg, #3b82f6, #10b981) !important;
            border-color: #3b82f6 !important;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.18) !important;
        }

        .right-inner input[type="checkbox"]:checked::after,
        .right-inner .fi-checkbox-input:checked::after {
            content: '\2713' !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            color: #ffffff !important;
            font-size: 11px !important;
            font-weight: 700 !important;
            line-height: 18px !important;
        }

        .right-inner input[type="checkbox"]:hover {
            border-color: #60a5fa !important;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.12) !important;
        }

        .right-inner .fi-fo-field-wrp-label sup,
        .right-inner sup {
            color: #34d399 !important;
        }

        .right-inner .text-gray-950,
        .right-inner .text-gray-700,
        .right-inner .text-gray-600,
        .right-inner .dark\:text-white {
            color: #f8fafc !important;
        }

        .right-inner button[type="submit"] {
            background: linear-gradient(135deg, #10b981, #047857) !important;
            color: #ecfdf5 !important;
            font-weight: 700;
            border-radius: 14px !important;
            transition: 0.2s ease;
            min-height: 48px;
        }

        .forgot-password-row {
            margin-top: -6px;
            margin-bottom: 16px;
            text-align: right;
        }

        .forgot-password-link {
            color: #93c5fd !important;
            font-size: 13px;
            font-weight: 700;
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .forgot-password-link:hover {
            color: #34d399 !important;
            text-decoration: underline;
        }

        .right-inner button:hover {
            transform: translateY(-1px);
            box-shadow: 0 14px 30px rgba(16, 185, 129, 0.25);
        }

        .login-footer {
            text-align: center;
            padding: 14px 18px;
            font-size: 12px;
            color: #94a3b8;
            background: rgba(2, 6, 23, 0.72);
            border-top: 1px solid rgba(148, 163, 184, 0.08);
        }

        .otp-modal-backdrop {
            position: fixed;
            inset: 0;
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            background: rgba(2, 6, 23, 0.72);
            backdrop-filter: blur(10px);
        }

        .otp-modal {
            width: min(100%, 430px);
            border-radius: 20px;
            border: 1px solid rgba(148, 163, 184, 0.16);
            background: rgba(15, 23, 42, 0.96);
            box-shadow: 0 28px 90px rgba(2, 6, 23, 0.58);
            padding: 30px;
            color: #e5e7eb;
        }

        .otp-modal-icon {
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 14px;
            color: #34d399;
            background: rgba(16, 185, 129, 0.12);
            border: 1px solid rgba(52, 211, 153, 0.2);
            margin-bottom: 18px;
        }

        .otp-modal-eyebrow {
            font-size: 11px;
            letter-spacing: 0.18em;
            color: #34d399;
            text-transform: uppercase;
            font-weight: 700;
        }

        .otp-modal h2 {
            color: #f8fafc;
            font-size: 26px;
            line-height: 1.15;
            font-weight: 800;
            margin: 6px 0 10px;
        }

        .otp-modal-copy {
            color: #cbd5e1;
            margin-bottom: 22px;
        }

        .otp-modal-form {
            display: grid;
            gap: 16px;
        }

        .otp-modal label {
            display: block;
            margin-bottom: 8px;
            color: #f8fafc;
            font-weight: 700;
            font-size: 14px;
        }

        .otp-modal input {
            width: 100%;
            min-height: 46px;
            padding: 10px 14px;
            border-radius: 14px;
            border: 1px solid rgba(71, 85, 105, 0.7);
            background: rgba(2, 6, 23, 0.72);
            color: #f8fafc;
            font-size: 18px;
            letter-spacing: 0.18em;
            text-align: center;
        }

        .otp-modal input:focus {
            outline: none;
            border-color: #10b981;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.18);
        }

        .otp-modal button {
            min-height: 46px;
            width: 100%;
            border-radius: 14px;
            background: linear-gradient(135deg, #10b981, #047857);
            color: #ecfdf5;
            font-weight: 800;
            transition: 0.2s ease;
        }

        .otp-modal button:hover {
            transform: translateY(-1px);
            box-shadow: 0 14px 30px rgba(16, 185, 129, 0.25);
        }

        .otp-modal-error {
            margin-top: 8px;
            color: #f87171;
            font-size: 13px;
        }

        @media (max-width: 1024px) {
            .left-panel {
                padding: 40px;
            }

            .left-card h2 {
                font-size: 28px;
            }

            .left-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .login-body {
                flex-direction: column;
            }

            .left-panel {
                display: none;
            }

            .right-panel {
                width: 100%;
                border-left: none;
                padding: 28px 18px;
            }

            .header-inner {
                flex-direction: column;
                gap: 10px;
            }

            .header-text {
                position: static;
                transform: none;
            }

            .logo-left,
            .logo-circle {
                display: none !important;
            }
        }

        @media (max-width: 480px) {
            .right-inner {
                padding: 24px 20px;
            }

            .right-inner h1 {
                font-size: 24px;
            }

            .otp-modal {
                padding: 24px 20px;
            }
        }
    </style>

    <header class="login-header">
        <div class="header-inner">
            <div class="logo-left">
                <div class="logo-square">
                    <img src="{{ asset('images/Logo.png') }}" alt="Hilongos seal">
                </div>
                <div class="logo-square">
                    <img src="{{ $activeLogo ? asset('storage/' . $activeLogo->pres_gov) : asset('images/Bagong-Pilipinas.png') }}"
                        alt="Provincial Logo">
                </div>
            </div>

            <div class="header-text">
                <div class="ht-top">Republic of the Philippines · Province of Leyte</div>
                <div class="ht-main">Municipality of Hilongos</div>
                <div class="ht-sub flex items-center justify-center gap-2">
                    <x-heroicon-o-scale class="w-4 h-4 text-emerald-400" />
                    <span>Sangguniang Bayan Legislative System</span>
                </div>
            </div>

            <div class="logo-circle">
                <img src="{{ $activeLogo ? asset('storage/' . $activeLogo->lgu_hilongos) : asset('images/Angat-ka.png') }}"
                    alt="LGU Logo">
            </div>
        </div>
    </header>

    <div class="login-body">
        <div class="left-panel">
            <div class="left-tag">SB Hilongos Portal</div>

            <div class="left-card">
                <h2>Secure access for authorized legislative staff and council officers.</h2>
                <p>
                    Use this portal to review legislative records, manage ordinances, publish announcements,
                    and keep official proceedings organized in one internal system.
                </p>

                <div class="left-grid">
                    <div class="left-metric">
                        <div class="metric-label">Access level</div>
                        <div class="metric-value">Admin-approved users only</div>
                    </div>

                    <div class="left-metric">
                        <div class="metric-label">Core modules</div>
                        <div class="metric-value">ORBOS, Ordinances, and Announcements</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="right-panel">
            <div class="right-inner">
                <div class="right-eyebrow">Legislative System</div>
                <h1>Sign in to your account</h1>
                <p class="subtitle">Enter your credentials to continue to the internal administrative portal.</p>

                <div class="notice-box">
                    Government records portal. Authorized staff access only.
                </div>

                <x-filament-panels::form wire:submit="authenticate">
                    {{ $this->form }}

                    @if (filament()->hasPasswordReset())
                        <div class="forgot-password-row">
                            <a class="forgot-password-link" href="{{ filament()->getRequestPasswordResetUrl() }}">
                                Forgot password?
                            </a>
                        </div>
                    @endif

                    <x-filament::button type="submit" size="lg" wire:loading.attr="disabled"
                        wire:target="authenticate"> <span wire:loading.remove wire:target="authenticate">Sign In</span>
                        <span wire:loading wire:target="authenticate">Authenticating...</span>
                    </x-filament::button>
                </x-filament-panels::form>
            </div>
        </div>
    </div>


    <footer class="login-footer">
        © 2026 SB Hilongos Legislative Tracking System
    </footer>

    @if ($showLoginOtpModal)
        @include('auth.login-otp', [
            'email' => session('login_otp_email'),
            'expiresAt' => session('login_otp_expires_at'),
        ])
    @endif

    @script
        <script>
            function initLoginPageScripts() {
                let challengeRedirectTimer = null;
                const challengeUrl = @js(route('login.challenge'));
                const initialLockoutSeconds = @js($initialLockoutSeconds);
                const shouldRedirectToChallenge = @js($shouldRedirectToChallenge);

                function scheduleChallengeRedirect(seconds) {
                    if (challengeRedirectTimer) {
                        return;
                    }

                    if (!Number.isFinite(seconds)) {
                        return;
                    }

                    challengeRedirectTimer = setTimeout(function() {
                        window.location.href = challengeUrl;
                    }, Math.max(seconds, 0) * 1000);
                }

                function scheduleChallengeRedirectFromText(text) {
                    const match = text.match(/Account locked for\s+(\d+)\s+seconds/i);

                    if (!match) {
                        return;
                    }

                    scheduleChallengeRedirect(Number.parseInt(match[1], 10));
                }

                function clearPasswordField() {
                    const passwordInputs = document.querySelectorAll('input[type="password"]');
                    passwordInputs.forEach(input => {
                        input.value = '';
                        input.dispatchEvent(new Event('input', {
                            bubbles: true
                        }));
                    });
                }

                setTimeout(function() {
                    const errorMessages = document.querySelectorAll(
                        '[class*="error"], .text-danger, .fi-fo-field-wrp-error, .fi-alert-error'
                    );
                    if (errorMessages.length > 0) {
                        clearPasswordField();
                    }
                }, 200);

                const observer = new MutationObserver(function(mutations) {
                    mutations.forEach(function(mutation) {
                        if (mutation.type === 'characterData') {
                            const text = mutation.target.textContent || '';
                            clearPasswordField();
                            scheduleChallengeRedirectFromText(text);
                        }

                        if (mutation.addedNodes.length > 0) {
                            mutation.addedNodes.forEach(function(node) {
                                if (node.nodeType === 1) {
                                    const text = node.textContent || '';

                                    if (
                                        text.includes('credentials') ||
                                        text.includes('attempt') ||
                                        text.includes('lock')
                                    ) {
                                        clearPasswordField();
                                        scheduleChallengeRedirectFromText(text);
                                    }

                                    if (
                                        node.classList && (
                                            node.classList.contains('text-danger') ||
                                            node.classList.contains('fi-fo-field-wrp-error') ||
                                            node.closest('[class*="error"]')
                                        )
                                    ) {
                                        clearPasswordField();
                                    }
                                }
                            });
                        }
                    });
                });

                window.addEventListener('login-lockout-triggered', function(event) {
                    const seconds = Number.parseInt(event.detail?.seconds ?? 0, 10);

                    scheduleChallengeRedirect(seconds);
                });

                if (shouldRedirectToChallenge) {
                    scheduleChallengeRedirect(0);
                } else if (initialLockoutSeconds > 0) {
                    scheduleChallengeRedirect(initialLockoutSeconds);
                }

                scheduleChallengeRedirectFromText(document.body.textContent || '');

                observer.observe(document.body, {
                    childList: true,
                    characterData: true,
                    subtree: true
                });
            }

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', initLoginPageScripts);
            } else {
                initLoginPageScripts();
            }

            window.addEventListener("pageshow", function (event) {
                if (event.persisted) {
                    window.location.reload();
                }
            });
        </script>
    @endscript
</x-filament-panels::page.simple>
