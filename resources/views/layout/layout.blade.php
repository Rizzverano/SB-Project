@php
    $activeLogo = \App\Models\Logo::where('is_published', true)->where('is_archived', false)->latest()->first();

    $announcements = \App\Models\Announcement::where('published', true)->where('is_archived', false)->latest()->get();
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Sangguniang Bayan - Hilongos, Leyte</title>
    <link rel="stylesheet" href="{{ asset('css/filament/main.css') }}">

    <link rel="icon" type="image/x-icon" href="{{ asset('images/Logo.png') }}">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Source+Sans+3:wght@300;400;600;700&display=swap"
        rel="stylesheet">
    <style>
        /* Dropdown hover */
        .dropdown:hover .dropdown-menu {
            display: block;
        }

        .dropdown-menu {
            display: none;
        }

        /* Gradient divider */
        .gradient-divider {
            height: 4px;
            background: linear-gradient(90deg, #0d3b6e, #2ecc71, #1565c0, #2ecc71, #0d3b6e);
        }

        /* Hero pattern */
        .hero-pattern::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>

<body class="bg-slate-50 font-sans text-gray-600 overflow-x-hidden">
    <div class="w-full max-w-[100vw] overflow-x-hidden">


        <!-- ══════════════════ HEADER ══════════════════ -->
        <header class="relative overflow-hidden">

            <!-- Background -->
            <img src="{{ asset('images/legis-naming.jpg') }}" class="absolute inset-0 w-full h-full object-fit z-0">

            <div class="absolute inset-0 bg-blue-900/80 z-10"></div>

            <div class="relative px-4 sm:px-6 lg:px-8 py-6 z-10">

                <!-- DESKTOP LAYOUT -->
                <div class="hidden sm:flex items-center justify-between relative">

                    <!-- Left Logos -->
                    <div class="flex items-center gap-3">

                        <!-- Sangguniang Logo -->
                        <div class="w-16 h-16 md:w-20 md:h-20">
                            <img src="{{ asset('images/Logo.png') }}"
                                class="w-full h-full object-cover rounded-full border-2 border-green-300 bg-slate-50">
                        </div>

                        <!-- Bagong Pilipinas -->
                        <div class="w-16 h-16 md:w-20 md:h-20">
                            <img src="{{ $activeLogo ? asset('storage/' . $activeLogo->pres_gov) : asset('images/Bagong-Pilipinas.png') }}"
                                class="w-full h-full object-cover rounded-full border-2 border-green-300 bg-slate-50">
                        </div>

                    </div>

                    <!-- Title -->
                    <div class="absolute left-1/2 -translate-x-1/2 text-center">
                        <p class="text-green-300 text-xs tracking-[0.2em] uppercase">
                            Office of the
                        </p>

                        <h1 class="font-playfair text-white text-3xl font-bold leading-tight">
                            Sangguniang Bayan<br>Hilongos, Leyte
                        </h1>
                    </div>

                    <!-- Right Logo -->
                    <div class="w-16 h-16 md:w-20 md:h-20">
                        <img src="{{ $activeLogo ? asset('storage/' . $activeLogo->lgu_hilongos) : asset('images/Angat-ka.png') }}"
                            class="w-full h-full object-cover rounded-full border-2 border-green-300 bg-slate-50">
                    </div>

                </div>

                <!-- MOBILE LAYOUT -->
                <div class="flex flex-col items-center text-center sm:hidden">

                    <p class="text-green-300 text-xs tracking-[0.2em] uppercase">
                        Office of the
                    </p>

                    <h1 class="font-playfair text-white text-2xl font-bold leading-tight">
                        Sangguniang Bayan<br>Hilongos, Leyte
                    </h1>

                    <!-- ONLY SANGGUNIANG LOGO -->
                    <div class="mt-4 w-20 h-20">
                        <img src="{{ asset('images/Logo.png') }}"
                            class="w-full h-full object-cover rounded-full border-2 border-green-300 bg-slate-50">
                    </div>

                </div>

            </div>
        </header>


        <div class="gradient-divider"></div>


        <!-- ══════════════════ NAVIGATION ══════════════════ -->
        <nav class="bg-blue-800 border-b-[3px] border-green-300"> <!-- Mobile hamburger -->
            <div class="flex items-center justify-between px-4 py-2 md:hidden"> <span
                    class="text-white text-xs font-bold uppercase tracking-wider">Menu</span>

                <button id="hamburger" class="text-white p-2 hover:text-green-300 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>

            </div>


            <!-- Mobile menu -->
            <div id="mobile-menu"
                class="md:hidden bg-blue-900 border-t border-white/10 overflow-hidden max-h-0 transition-[max-height] duration-300 ease-in-out">

                <!-- Home -->
                <a href="{{ route('home') }}"
                    class="block px-4 py-2.5 text-xs font-semibold uppercase border-b border-white/10 transition-colors
        {{ request()->routeIs('home') ? 'bg-green-700 text-white' : 'text-white hover:bg-green-700' }}">
                    Home
                </a>

                <!-- About -->
                <div class="border-b border-white/10">
                    <span class="block px-4 py-2.5 text-green-300 text-xs font-bold uppercase">
                        About the Office
                    </span>

                    <a href="{{ route('about') }}"
                        class="block px-4 py-2.5 text-xs border-b border-white/10 transition-all duration-200
            {{ request()->routeIs('about*')
                ? 'bg-blue-700 text-green-300 font-semibold border-l-4 border-green-400 pl-3'
                : 'text-white hover:bg-blue-700 hover:text-green-300' }}">
                        About the SB
                    </a>

                    <a href="{{ route('sb.members') }}"
                        class="block px-4 py-2.5 text-xs border-b border-white/10 transition-all duration-200
            {{ request()->routeIs('sb.members*')
                ? 'bg-blue-700 text-green-300 font-semibold border-l-4 border-green-400 pl-3'
                : 'text-white hover:bg-blue-700 hover:text-green-300' }}">
                        Members
                    </a>

                    <a href="{{ route('gallery') }}"
                        class="block px-4 py-2.5 text-xs border-b border-white/10 transition-all duration-200
            {{ request()->routeIs('gallery*')
                ? 'bg-blue-700 text-green-300 font-semibold border-l-4 border-green-400 pl-3'
                : 'text-white hover:bg-blue-700 hover:text-green-300' }}">
                        Activities
                    </a>
                </div>

                <!-- Transparency -->
                <a href="{{ route('legislative_index') }}"
                    class="block px-4 py-2.5 text-xs font-semibold uppercase border-b border-white/10 transition-colors
        {{ request()->routeIs('legislative_index') ? 'bg-green-700 text-white' : 'text-white hover:bg-green-700' }}">
                    Transparency Records
                </a>

                <!-- Legislative Process -->
                <a href="{{ route('legislative.process') }}"
                    class="block px-4 py-2.5 text-xs font-semibold uppercase border-b border-white/10 transition-colors
        {{ request()->routeIs('legislative.process') ? 'bg-green-700 text-white' : 'text-white hover:bg-green-700' }}">
                    Legislative Process
                </a>

                <!-- Contact -->
                <a href="{{ route('contact') }}"
                    class="block px-4 py-2.5 text-xs font-semibold uppercase border-b border-white/10 transition-colors
        {{ request()->routeIs('contact') ? 'bg-green-700 text-white' : 'text-white hover:bg-green-700' }}">
                    Contact Us
                </a>

                <!-- Admin Links (mobile only) -->
                <div class="sm:hidden border-t border-white/10 px-4 py-2.5 flex items-center gap-3">
                    <a href="{{ route('filament.admin.auth.login') }}" title="Admin Portal"
                        class="flex items-center gap-2 text-xs font-semibold uppercase text-blue-300 hover:text-white transition-colors">
                        <i class="fa-solid fa-user-shield"></i>
                        <span>Admin Portal</span>
                    </a>

                    @auth
                        @if (auth()->user()->isAdmin() || auth()->user()->isMember())
                            <a href="{{ route('filament.admin.pages.dashboard') }}" title="Go Back to Dashboard"
                                class="flex items-center gap-2 text-xs font-semibold uppercase text-blue-300 hover:text-white transition-colors">
                                <i class="fa-solid fa-arrow-left"></i>
                                <span>Dashboard</span>
                            </a>
                        @endif
                    @endauth
                </div>

            </div>

            <!-- Desktop nav row (CENTERED) -->
            <div class="hidden md:flex justify-center">
                <div class="flex items-stretch">
                    <a href="{{ route('home') }}"
                        class="px-4 py-3 text-white text-xs font-semibold uppercase tracking-wide border-r border-white/10 whitespace-nowrap
            {{ request()->routeIs('home') ? 'bg-green-700' : 'hover:bg-green-700' }}">
                        Home
                    </a>

                    <!-- Dropdown: About -->
                    <div class="dropdown relative border-r border-white/10">
                        <button
                            class="px-4 py-3 text-white text-xs font-semibold uppercase tracking-wide flex items-center gap-1 hover:bg-green-700 transition-colors whitespace-nowrap h-full">
                            About the Office
                            <svg class="w-2.5 h-2.5 fill-current" viewBox="0 0 10 6">
                                <path d="M0 0l5 6 5-6z" />
                            </svg>
                        </button>
                        <div
                            class="dropdown-menu absolute top-full left-1/2 -translate-x-1/2 bg-blue-900 min-w-[200px] z-50 border-t-2 border-green-300 shadow-xl">
                            <a href="{{ route('about') }}"
                                class="block px-4 py-2.5 text-xs border-b border-white/10 transition-all duration-200
                    {{ request()->routeIs('about*')
                        ? 'bg-blue-700 text-green-300 font-semibold border-l-4 border-green-400'
                        : 'text-white hover:bg-blue-700 hover:text-green-300' }}">
                                About the SB
                            </a>

                            <a href="{{ route('sb.members') }}"
                                class="block px-4 py-2.5 text-xs border-b border-white/10 transition-all duration-200
                    {{ request()->routeIs('sb.members*')
                        ? 'bg-blue-700 text-green-300 font-semibold border-l-4 border-green-400'
                        : 'text-white hover:bg-blue-700 hover:text-green-300' }}">
                                Members
                            </a>

                            <a href="{{ route('gallery') }}"
                                class="block px-4 py-2.5 text-xs border-b border-white/10 transition-all duration-200
                    {{ request()->routeIs('gallery*')
                        ? 'bg-blue-700 text-green-300 font-semibold border-l-4 border-green-400'
                        : 'text-white hover:bg-blue-700 hover:text-green-300' }}">
                                Activities
                            </a>
                        </div>
                    </div>

                    <a href="{{ route('legislative_index') }}"
                        class="px-4 py-3 text-white text-xs font-semibold uppercase tracking-wide border-r border-white/10 whitespace-nowrap transition-colors
            {{ request()->routeIs('legislative_index') ? 'bg-green-700' : 'hover:bg-green-700' }}">
                        Transparency Records
                    </a>

                    <a href="{{ route('legislative.process') }}"
                        class="px-4 py-3 text-white text-xs font-semibold uppercase tracking-wide border-r border-white/10 whitespace-nowrap transition-colors
            {{ request()->routeIs('legislative.process') ? 'bg-green-700' : 'hover:bg-green-700' }}">
                        Legislative Process
                    </a>

                    <a href="{{ route('contact') }}"
                        class="px-4 py-3 text-white text-xs font-semibold uppercase tracking-wide whitespace-nowrap transition-colors
            {{ request()->routeIs('contact') ? 'bg-green-700' : 'hover:bg-green-700' }}">
                        Contact Us
                    </a>
                </div>
            </div>
        </nav>

        <!-- ══════════════════ HERO ══════════════════ -->
        <section class="relative flex items-center justify-center min-h-[340px] md:min-h-[420px] overflow-hidden">

            <!-- Background Images (crossfade slideshow) -->
            <div class="absolute inset-0 z-0">
                <img src="{{ asset('images/legis-building.png') }}"
                    class="hero-bg-img absolute inset-0 w-full h-full object-fill"
                    style="animation: heroCrossfade 6s infinite 0s;" alt="">
                <img src="{{ asset('images/Hilongos-Lgu.jpg') }}"
                    class="hero-bg-img absolute inset-0 w-full h-full object-fill"
                    style="animation: heroCrossfade 6s infinite 3s;" alt="">
            </div>

            <!-- Dark overlay -->
            <div class="absolute inset-0 bg-blue-950/70 z-10"></div>

            <!-- Decorative circles -->
            <div class="absolute -top-40 -right-32 w-[500px] h-[500px] rounded-full bg-green-300 opacity-[0.07] z-10">
            </div>
            <div class="absolute -bottom-36 -left-24 w-[380px] h-[380px] rounded-full bg-blue-600 opacity-10 z-10">
            </div>

            <!-- Content -->
            <div class="relative z-20 text-center px-4 animate-fadeUp">
                <p class="text-green-300 text-xs tracking-[0.3em] uppercase mb-3">
                    Hilongos, Leyte • Local Government Unit
                </p>

                <h2
                    class="font-playfair text-white text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold leading-tight mb-4">
                    Sangguniang<br>Bayan
                </h2>

                <p class="text-white/60 text-xs sm:text-sm md:text-base max-w-xl mx-auto leading-relaxed mb-2 px-2">
                    The legislative body of the Local Government of Hilongos — serving the people through principled
                    governance and transparent lawmaking.
                </p>
            </div>
        </section>

        <style>
            @keyframes heroCrossfade {
                0% {
                    opacity: 1;
                }

                45% {
                    opacity: 1;
                }

                50% {
                    opacity: 0;
                }

                95% {
                    opacity: 0;
                }

                100% {
                    opacity: 1;
                }
            }
        </style>

        <!-- ══════════════════ QUICK LINKS ══════════════════ -->
        <div class="bg-slate-100 border-b border-slate-100 flex items-stretch relative">
            <!-- LEFT SPACER (balances right side) -->
            <div class="w-10"></div>

            <!-- CENTER QUICK LINKS -->
            <div class="flex justify-center flex-1 overflow-x-auto no-scrollbar">

                <a href="{{ route('legislative_index') }}" title="Transparency Records"
                    class="flex flex-col items-center justify-center gap-1.5 px-3 sm:px-5 py-3 sm:py-4 text-[10px] sm:text-[11px] font-bold uppercase tracking-wide border-r border-slate-100 transition group
            {{ request()->routeIs('legislative_index')
                ? 'bg-blue-800 text-white'
                : 'text-blue-800 hover:bg-blue-800 hover:text-white' }}">
                    <i
                        class="fa-solid fa-file-lines text-xl transition-transform
                {{ request()->routeIs('legislative_index') ? 'scale-110' : 'group-hover:scale-110' }}">
                    </i>
                    <span class="hidden sm:inline">Transparency Records</span>
                </a>

                <a href="{{ route('sb.members') }}" title="SB Members"
                    class="flex flex-col items-center justify-center gap-1.5 px-3 sm:px-5 py-3 sm:py-4 text-[10px] sm:text-[11px] font-bold uppercase tracking-wide border-r border-slate-100 transition group
            {{ request()->routeIs('sb.members*')
                ? 'bg-blue-800 text-white'
                : 'text-blue-800 hover:bg-blue-800 hover:text-white' }}">
                    <i
                        class="fa-solid fa-users text-xl transition-transform
                {{ request()->routeIs('sb.members*') ? 'scale-110' : 'group-hover:scale-110' }}">
                    </i>
                    <span class="hidden sm:inline">SB Members</span>
                </a>

                <a href="{{ route('legislative.process') }}" title="Legislative Process"
                    class="flex flex-col items-center justify-center gap-1.5 px-3 sm:px-5 py-3 sm:py-4 text-[10px] sm:text-[11px] font-bold uppercase tracking-wide transition group
            {{ request()->routeIs('legislative.process*')
                ? 'bg-blue-800 text-white'
                : 'text-blue-800 hover:bg-blue-800 hover:text-white' }}">
                    <i
                        class="fa-solid fa-list-check text-xl transition-transform
                {{ request()->routeIs('legislative.process*') ? 'scale-110' : 'group-hover:scale-110' }}">
                    </i>
                    <span class="hidden sm:inline">Legislative Process</span>
                </a>

                <a href="{{ route('gallery') }}" title="Activities"
                    class="flex flex-col items-center justify-center gap-1.5 px-3 sm:px-5 py-3 sm:py-4 text-[10px] sm:text-[11px] font-bold uppercase tracking-wide transition group
            {{ request()->routeIs('gallery*')
                ? 'bg-blue-800 text-white'
                : 'text-blue-800 hover:bg-blue-800 hover:text-white' }}">
                    <i
                        class="fa-solid fa-images text-xl transition-transform
                {{ request()->routeIs('gallery*') ? 'scale-110' : 'group-hover:scale-110' }}">
                    </i>
                    <span class="hidden sm:inline">Activities</span>
                </a>

            </div>

            <div class="flex items-center justify-end pr-3 gap-2">
                <a href="{{ route('filament.admin.auth.login') }}" title="Admin Portal"
                    class="hidden sm:flex w-10 h-10 items-center justify-center text-blue-500 shadow-md hover:bg-blue-800 hover:text-white">
                    <i class="fa-solid fa-user-shield"></i>
                </a>
                @auth
                    @if (auth()->user()->isAdmin() || auth()->user()->isMember())
                        <a href="{{ route('filament.admin.pages.dashboard') }}" title="Go Back"
                            class="hidden sm:flex w-10 h-10 items-center justify-center text-blue-500 shadow-md hover:bg-blue-800 hover:text-white">
                            <i class="fa-solid fa-arrow-left"></i>
                        </a>
                    @endif
                @endauth
            </div>
        </div>
    </div>

    <main class="flex-1 w-full">
        <div class="bg-green-900 w-full py-6 flex items-center justify-center">
            <div
                class="bg-blue-900 w-full min-h-24 flex items-center justify-center px-6 py-8 relative overflow-hidden rounded-lg">

                {{-- Top accent bar --}}
                <div
                    class="absolute top-0 left-0 right-0 h-[3px] bg-gradient-to-r from-green-600 via-blue-500 to-green-600">
                </div>

                {{-- Corner dots --}}
                <div class="absolute top-4 left-6 w-1.5 h-1.5 rounded-full bg-green-500 opacity-60"></div>
                <div class="absolute top-4 right-6 w-1.5 h-1.5 rounded-full bg-green-500 opacity-60"></div>
                <div class="absolute bottom-4 left-6 w-1.5 h-1.5 rounded-full bg-green-500 opacity-60"></div>
                <div class="absolute bottom-4 right-6 w-1.5 h-1.5 rounded-full bg-green-500 opacity-60"></div>

                @if ($announcements->count())
                    <div class="text-center text-white w-full max-w-4xl">

                        {{-- Label --}}
                        <div class="flex items-center justify-center gap-3 mb-3">
                            <div class="h-px w-10 bg-green-400/40"></div>
                            <span
                                class="text-xs font-medium tracking-[3px] uppercase text-green-400">Announcements</span>
                            <div class="h-px w-10 bg-green-400/40"></div>
                        </div>

                        <div id="announcement-slider">
                            @foreach ($announcements as $index => $announcement)
                                <div
                                    class="announcement-slide {{ $index !== 0 ? 'hidden' : '' }} transition-all duration-700 ease-in-out">
                                    <p class="text-lg md:text-xl font-semibold text-blue-50 tracking-wide">
                                        {{ $announcement->title }}
                                    </p>
                                    <p
                                        class="mt-1 text-sm md:text-base text-blue-100/70 leading-relaxed px-2 max-w-2xl mx-auto">
                                        {{ strip_tags($announcement->description) }}
                                    </p>
                                </div>
                            @endforeach
                        </div>

                    </div>
                @else
                    <div class="text-center text-white">
                        <div class="flex items-center justify-center gap-3 mb-2">
                            <div class="h-px w-10 bg-green-400/40"></div>
                            <span
                                class="text-xs font-medium tracking-[3px] uppercase text-green-400">Announcements</span>
                            <div class="h-px w-10 bg-green-400/40"></div>
                        </div>
                        <p class="text-sm text-white/50 mt-1">No announcements available</p>
                    </div>
                @endif

            </div>
        </div>

        @yield('content')

    </main>


    @stack('scripts')

    <!-- ══════════════════ Divider Line ══════════════════ -->
    <section class="bg-gradient-to-r from-blue-900 to-blue-800 h-2 w-full"></section>

    <!-- ══════════════════ FOOTER ══════════════════ -->
    <footer class="bg-blue-950 text-white/70 px-4 md:px-8 pt-10 pb-6">
        <div class="max-w-6xl mx-auto grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 mb-8">
            <div>
                <h4
                    class="text-green-300 text-xs uppercase tracking-[0.2em] font-bold mb-4 pb-2 border-b border-green-300/30">
                    Office of the SB Hilongos</h4>
                <p class="text-xs leading-7 text-white/60">The Sangguniang Bayan is the legislative body of the Local
                    Government of Hilongos, responsible for enacting Local ordinances and resolutions.</p>
            </div>
            <div>
                <h4
                    class="text-green-300 text-xs uppercase tracking-[0.2em] font-bold mb-4 pb-2 border-b border-green-300/30">
                    Quick Links</h4>

                <a href="{{ route('legislative_index') }}"
                    class="block text-xs leading-8 transition-colors
   {{ request()->routeIs('legislative_index*')
       ? 'text-green-300 font-semibold border-l-2 border-green-400 pl-2'
       : 'text-white/60 hover:text-green-300' }}">
                    Transparency Records
                </a>


                <a href="{{ route('legislative.process') }}"
                    class="block text-xs leading-8 transition-colors
                    {{ request()->routeIs('legislative.process*')
                        ? 'text-green-300 font-semibold border-l-2 border-green-400 pl-2'
                        : 'text-white/60 hover:text-green-300' }}">
                    Legislative Process
                </a>

                <a href="{{ route('about') }}"
                    class="block text-xs leading-8 transition-colors
   {{ request()->routeIs('about*')
       ? 'text-green-300 font-semibold border-l-2 border-green-400 pl-2'
       : 'text-white/60 hover:text-green-300' }}">
                    About Us
                </a>

                <a href="{{ route('gallery') }}"
                    class="block text-xs leading-8 transition-colors
   {{ request()->routeIs('gallery*')
       ? 'text-green-300 font-semibold border-l-2 border-green-400 pl-2'
       : 'text-white/60 hover:text-green-300' }}">
                    Activities
                </a>


                <a href="{{ route('sb.members') }}"
                    class="block text-xs leading-8 transition-colors
    {{ request()->routeIs('sb.members*')
        ? 'text-green-300 font-semibold border-l-2 border-green-400 pl-2'
        : 'text-white/60 hover:text-green-300' }}">
                    SB Members
                </a>

            </div>
            <div>
                <h4
                    class="text-green-300 text-xs uppercase tracking-[0.2em] font-bold mb-4 pb-2 border-b border-green-300/30">
                    Contact Information</h4>
                <p class="text-xs sm:text-sm leading-6 sm:leading-8 text-white/60">Address: Western Barangay Hilongos,
                    Leyte</p>
                <p class="text-xs sm:text-sm leading-6 sm:leading-8 text-white/60">Phone: (+63) 954 305 6206 </p>
                <p class="text-xs sm:text-sm leading-6 sm:leading-8 text-white/60">Opening Hours: Monday to Friday</p>
                <p class="text-xs sm:text-sm leading-6 sm:leading-8 text-white/60">8:00 AM – 5:00 PM (no noon break)
                </p>
            </div>
        </div>
        <div
            class="max-w-6xl mx-auto pt-5 border-t border-white/10 flex flex-col sm:flex-row justify-between items-center gap-2 text-[11px] text-white/40">
            <span>© 2026 Office of the Sangguniang Bayan, Hilongos Leyte. All rights reserved.</span>
        </div> <button id="scrollTopBtn" onclick="window.scrollTo({ top: 0, behavior: 'smooth' })"
            class="fixed bottom-6 right-6 w-12 h-12 rounded-full bg-green-600 text-white
                    flex items-center justify-center shadow-lg z-50
                    opacity-0 translate-y-4 pointer-events-none
                    transition-all duration-300 ease-in-out">
            <i class="fa-solid fa-arrow-up"></i> </button>
    </footer>

    <script src="{{ asset('js/filament/scroll-to-top.js') }}"></script>
    <script src="{{ asset('js/filament/announcement.js') }}"></script>
    <script src="{{ asset('js/filament/hamburger.js') }}"></script>
    <script src="{{ asset('js/filament/activities.js') }}"></script>
</body>

</html>
