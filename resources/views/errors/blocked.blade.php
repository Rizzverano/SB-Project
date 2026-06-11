<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Access Blocked</title>

    <link rel="icon" type="image/x-icon" href="{{ asset('images/Logo.png') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    @vite(['resources/css/app.css'])

    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Source+Sans+3:wght@300;400;600;700&display=swap" rel="stylesheet">
</head>

<body class="min-h-screen bg-slate-50 font-sans flex flex-col text-gray-600">
    <x-loader />
    {{-- Header --}}
    <header class="bg-blue-900 px-6 py-4 flex items-center justify-center gap-3 shadow-md">
        <img
            src="{{ asset('images/Logo.png') }}"
            class="w-10 h-10 object-cover rounded-full border-2 border-green-300 bg-white"
        >

        <div class="text-center">
            <p class="text-green-300 text-[10px] tracking-[0.2em] uppercase">
                Office of the
            </p>

            <h1 class="font-playfair text-white text-lg font-bold leading-tight">
                Sangguniang Bayan · Hilongos, Leyte
            </h1>
        </div>
    </header>

    {{-- Main --}}
    <main class="flex-1 flex items-center justify-center px-4 py-12">

        <div class="max-w-3xl w-full">

            {{-- Main Card --}}
            <div class="bg-gradient-to-br from-blue-900 via-blue-800 to-green-900 rounded-2xl shadow-xl overflow-hidden">

                {{-- Top Accent --}}
                <div class="h-1 bg-gradient-to-r from-green-400 via-white/30 to-green-400"></div>

                <div class="relative p-8 md:p-12 text-center">

                    {{-- Decorative Corners --}}
                    <div class="absolute top-5 left-5 w-2 h-2 rounded-full bg-green-300/50"></div>
                    <div class="absolute top-5 right-5 w-2 h-2 rounded-full bg-green-300/50"></div>
                    <div class="absolute bottom-5 left-5 w-2 h-2 rounded-full bg-green-300/50"></div>
                    <div class="absolute bottom-5 right-5 w-2 h-2 rounded-full bg-green-300/50"></div>

                    {{-- Warning Icon --}}
                    <div class="flex justify-center mb-8">
                        <div class="w-20 h-20 rounded-full bg-white/10 border border-green-300/30 backdrop-blur-sm flex items-center justify-center">

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="w-10 h-10 text-red-300"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="1.8">

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M12 9v3m0 4h.01M5.07 19h13.86c1.54 0 2.5-1.67 1.73-3L13.73 4c-.77-1.33-2.69-1.33-3.46 0L3.34 16c-.77 1.33.19 3 1.73 3z" />
                            </svg>

                        </div>
                    </div>

                    {{-- Label --}}
                    <div class="flex items-center justify-center gap-3 mb-4">

                        <div class="h-px w-10 bg-green-300/40"></div>

                        <span class="text-green-300 text-xs tracking-[0.3em] uppercase">
                            Access Blocked
                        </span>

                        <div class="h-px w-10 bg-green-300/40"></div>

                    </div>

                    {{-- Heading --}}
                    <h2 class="font-playfair text-4xl font-bold text-white mb-5">
                        Your Access Has Been Restricted
                    </h2>

                    {{-- Description --}}
                    <p class="text-white/70 text-sm md:text-base leading-relaxed max-w-xl mx-auto">
                        Your
                        <span class="font-semibold text-red-300">
                            email address and/or device
                        </span>
                        has been blocked because inappropriate or prohibited language was detected
                        in a previously submitted message.
                    </p>

                    <p class="mt-5 text-white/50 text-sm leading-relaxed max-w-xl mx-auto">
                        If you believe this action was taken in error, please contact the
                        <span class="text-green-300 font-medium">
                            Sangguniang Bayan Office of Hilongos
                        </span>
                        through its official communication channels for assistance.
                    </p>

                    {{-- Button --}}
                    <div class="mt-10">

                        <a
                            href="{{ route('home') }}"
                            class="inline-flex items-center gap-2 px-6 py-3 rounded-md bg-green-600 hover:bg-green-500 text-white font-bold transition-all duration-300">

                            <i class="fa-solid fa-arrow-left"></i>

                            Return to Home

                        </a>

                    </div>

                </div>

                {{-- Footer --}}
                <div class="border-t border-white/10 bg-black/10 px-6 py-4 text-center">

                    <p class="text-xs text-white/30">
                        © 2026 Office of the Sangguniang Bayan, Hilongos, Leyte
                    </p>

                </div>

            </div>

        </div>

    </main>

</body>
</html>
```
