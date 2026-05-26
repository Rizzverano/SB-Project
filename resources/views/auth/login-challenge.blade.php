<!DOCTYPE html>
<html>
<head>
    <title>Security Verification</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="icon" type="image/x-icon" href="{{ asset('images/Logo.png') }}">
    <style>
        body {
            background:
                radial-gradient(circle at top left, rgba(59, 130, 246, 0.18), transparent 28%),
                radial-gradient(circle at top right, rgba(16, 185, 129, 0.14), transparent 32%),
                linear-gradient(180deg, #0f172a 0%, #111827 46%, #0b1220 100%);
            font-family: 'Segoe UI', sans-serif;
            color: #e5e7eb;
        }

        .card {
            background: rgba(15, 23, 42, 0.78);
            border: 1px solid rgba(148, 163, 184, 0.12);
            backdrop-filter: blur(14px);
            box-shadow: 0 24px 80px rgba(2, 6, 23, 0.45);
        }

        .input {
            background: rgba(2, 6, 23, 0.72);
            border: 1px solid rgba(71, 85, 105, 0.7);
            color: #f8fafc;
            border-radius: 12px;
            transition: 0.2s ease;
        }

        .input:focus {
            border-color: #10b981;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.2);
            outline: none;
        }

        .btn {
            background: linear-gradient(135deg, #10b981, #047857);
            color: #ecfdf5;
            font-weight: 700;
            border-radius: 12px;
            transition: 0.2s ease;
        }

        .btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 12px 30px rgba(16, 185, 129, 0.25);
        }

        .label {
            color: #f8fafc;
        }

        .subtitle {
            color: #cbd5e1;
        }

        .error {
            color: #f87171;
        }

        .notice {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.12), rgba(16, 185, 129, 0.1));
            border: 1px solid rgba(59, 130, 246, 0.18);
            border-left: 4px solid #3b82f6;
            padding: 12px;
            border-radius: 10px;
            font-size: 13px;
            margin-bottom: 20px;
        }
        .grecaptcha-badge {
            display: none !important;
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center">

<div class="w-full max-w-md card rounded-2xl p-8">

    <div class="text-xs uppercase tracking-widest text-blue-400 mb-2">
        Security Layer
    </div>

    <h1 class="text-2xl font-extrabold text-white mb-2">
        Security Verification
    </h1>

    <p class="subtitle mb-6">
        Please verify to continue.
    </p>

    <div class="notice">
        Additional protection is required before accessing your account.
    </div>

    <form method="POST" action="{{ route('login.challenge.verify') }}" class="space-y-4">
        @csrf

        <div>
            <label class="block mb-2 label">
                Enter the challenge exactly as shown below:
            </label>

            <div class="mb-3 px-4 py-3 rounded-xl bg-slate-900/70 text-slate-100 border border-slate-700">
                <code class="font-mono">What is {{ $num1 }} + {{ $num2 }} ?</code>
            </div>

            <input type="text" name="answer"
                class="w-full px-4 py-2 input"
                autocomplete="off">

            <p class="text-xs text-slate-500 mt-3 text-center">
                Protected by reCAPTCHA &mdash;
                <a href="https://policies.google.com/privacy" class="underline">Privacy</a> &amp;
                <a href="https://policies.google.com/terms" class="underline">Terms</a>
            </p>

            @error('answer')
                <p class="error text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <input type="hidden" name="token" id="recaptcha-token">

        <button class="w-full py-2 btn">
            Verify
        </button>
    </form>
</div>

<script src="https://www.google.com/recaptcha/api.js?render={{ config('services.recaptcha.site_key') }}"></script>
<script>
    grecaptcha.ready(function () {
        grecaptcha.execute("{{ config('services.recaptcha.site_key') }}", {action:'login'})
            .then(function(token) {
                document.getElementById('recaptcha-token').value = token;
            });
    });

    // Kill back button navigation
    history.pushState(null, null, location.href);
    window.onpopstate = function () {
        location.replace("/admin/login");
    };

    // Fix browser BFCache (Chrome/Safari)
    window.addEventListener("pageshow", function (event) {
        if (event.persisted) {
            window.location.reload();
        }
    });
</script>

</body>
</html>
