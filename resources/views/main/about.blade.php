@extends('layout.layout')

@section('content')

{{-- ══════════════════ PAGE HERO ══════════════════ --}}
<div class="relative bg-gradient-to-br from-blue-950 via-blue-900 to-slate-900 py-20 px-4 overflow-hidden">
    <div class="absolute top-0 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] rounded-full border border-white/5"></div>
    <div class="absolute top-0 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[400px] h-[400px] rounded-full border border-white/5"></div>
    <div class="absolute -bottom-24 -right-24 w-64 h-64 rounded-full bg-green-500/10 blur-3xl"></div>
    <div class="absolute -top-12 -left-12 w-48 h-48 rounded-full bg-blue-400/10 blur-2xl"></div>
    <div class="relative z-10 text-center max-w-2xl mx-auto">
        <span class="inline-block text-green-400 text-xs tracking-[0.4em] uppercase font-semibold mb-4">
            Hilongos, Leyte • LGU
        </span>
        <h1 class="text-white text-4xl sm:text-5xl font-bold leading-tight mb-4" style="font-family: 'Playfair Display', serif;">
            About the Office
        </h1>
        <p class="text-white/50 text-sm leading-relaxed max-w-md mx-auto">
            Learn about the vision, mission, and location of the Sangguniang Bayan of Hilongos, Leyte.
        </p>
    </div>
</div>

{{-- ══════════════════ VISION ══════════════════ --}}
<section class="bg-slate-50 py-20 px-4 overflow-hidden">
    <div class="max-w-6xl mx-auto">
        <div class="grid md:grid-cols-2 gap-10 lg:gap-16 items-center">

            {{-- Image --}}
            <div class="relative group">
                <div class="absolute -inset-2 bg-gradient-to-br from-blue-800 to-blue-600 rounded-2xl opacity-20 blur-xl group-hover:opacity-30 transition-opacity duration-500"></div>
                <div class="relative rounded-2xl overflow-hidden shadow-xl border-4 border-white">
                    <img src="{{ asset('images/legis-building.jpg') }}"
                        class="w-full h-72 sm:h-80 md:h-96 object-cover group-hover:scale-105 transition-transform duration-700"
                        alt="Legislative Building">
                    <div class="absolute inset-0 bg-gradient-to-t from-blue-950/60 to-transparent"></div>
                    <div class="absolute bottom-4 left-4">
                        <span class="bg-white/10 backdrop-blur-sm border border-white/20 text-white text-[10px] tracking-[2px] uppercase px-3 py-1.5 rounded-full">
                            Legislative Building
                        </span>
                    </div>
                </div>
            </div>

            {{-- Text --}}
            <div>
                <span class="inline-flex items-center gap-2 text-blue-600 text-xs font-bold uppercase tracking-[0.3em] mb-4">
                    <span class="w-8 h-px bg-blue-600"></span>
                    Our Vision
                </span>

                <h2 class="text-3xl sm:text-4xl font-bold text-blue-900 mb-6 leading-tight" style="font-family: 'Playfair Display', serif;">
                    Guided by a Clear <br class="hidden sm:block"> Vision
                </h2>

                <div class="relative pl-5 border-l-4 border-green-400 mb-6">
                    <p class="text-slate-600 leading-8 text-sm sm:text-base">
                        A transparent, accountable, and people-centered legislative office committed to crafting responsive
                        and progressive laws that promote sustainable development, social justice, and improved quality of life
                        for every citizen of Hilongos.
                    </p>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div class="bg-white rounded-xl p-4 border border-slate-200 shadow-sm">
                        <i class="fa-solid fa-eye text-blue-700 mb-2 text-lg"></i>
                        <p class="text-xs font-bold text-blue-900 uppercase tracking-wide">Transparency</p>
                        <p class="text-xs text-slate-400 mt-0.5">Open governance for all</p>
                    </div>
                    <div class="bg-white rounded-xl p-4 border border-slate-200 shadow-sm">
                        <i class="fa-solid fa-scale-balanced text-blue-700 mb-2 text-lg"></i>
                        <p class="text-xs font-bold text-blue-900 uppercase tracking-wide">Accountability</p>
                        <p class="text-xs text-slate-400 mt-0.5">Responsible legislation</p>
                    </div>
                    <div class="bg-white rounded-xl p-4 border border-slate-200 shadow-sm">
                        <i class="fa-solid fa-seedling text-blue-700 mb-2 text-lg"></i>
                        <p class="text-xs font-bold text-blue-900 uppercase tracking-wide">Sustainability</p>
                        <p class="text-xs text-slate-400 mt-0.5">Long-term community growth</p>
                    </div>
                    <div class="bg-white rounded-xl p-4 border border-slate-200 shadow-sm">
                        <i class="fa-solid fa-people-group text-blue-700 mb-2 text-lg"></i>
                        <p class="text-xs font-bold text-blue-900 uppercase tracking-wide">People-Centered</p>
                        <p class="text-xs text-slate-400 mt-0.5">Citizens first approach</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- ══════════════════ DIVIDER ══════════════════ --}}
<div class="h-px bg-gradient-to-r from-transparent via-slate-300 to-transparent"></div>

{{-- ══════════════════ MISSION ══════════════════ --}}
<section class="bg-slate-50 py-20 px-4 overflow-hidden">
    <div class="max-w-6xl mx-auto">
        <div class="grid md:grid-cols-2 gap-10 lg:gap-16 items-center">

            {{-- Text (LEFT on desktop) --}}
            <div class="order-2 md:order-1">
                <span class="inline-flex items-center gap-2 text-green-600 text-xs font-bold uppercase tracking-[0.3em] mb-4">
                    <span class="w-8 h-px bg-green-600"></span>
                    Our Mission
                </span>

                <h2 class="text-3xl sm:text-4xl font-bold text-blue-900 mb-6 leading-tight" style="font-family: 'Playfair Display', serif;">
                    Driven by a <br class="hidden sm:block"> Strong Mission
                </h2>

                <div class="relative pl-5 border-l-4 border-blue-800 mb-6">
                    <p class="text-slate-600 leading-8 text-sm sm:text-base">
                        To efficiently enact ordinances and resolutions that address community needs, uphold democratic principles,
                        and strengthen collaboration between government and citizens for a progressive Hilongos.
                    </p>
                </div>

                <div class="space-y-3">
                    @php
                        $pillars = [
                            ['icon' => 'fa-gavel',         'title' => 'Enact Sound Laws',       'desc' => 'Craft ordinances that reflect community needs'],
                            ['icon' => 'fa-handshake',     'title' => 'Foster Collaboration',   'desc' => 'Bridge government and citizen participation'],
                            ['icon' => 'fa-landmark',      'title' => 'Uphold Democracy',       'desc' => 'Protect democratic principles in governance'],
                        ];
                    @endphp

                    @foreach ($pillars as $pillar)
                        <div class="flex items-start gap-4 bg-white rounded-xl p-4 border border-slate-200 shadow-sm hover:border-green-400 hover:shadow-md transition-all duration-300">
                            <div class="w-10 h-10 rounded-full bg-green-50 border border-green-200 flex items-center justify-center flex-shrink-0">
                                <i class="fa-solid {{ $pillar['icon'] }} text-green-700 text-sm"></i>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-blue-900 uppercase tracking-wide">{{ $pillar['title'] }}</p>
                                <p class="text-xs text-slate-400 mt-0.5">{{ $pillar['desc'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Image (RIGHT on desktop) --}}
            <div class="relative group order-1 md:order-2">
                <div class="absolute -inset-2 bg-gradient-to-br from-green-700 to-green-500 rounded-2xl opacity-20 blur-xl group-hover:opacity-30 transition-opacity duration-500"></div>
                <div class="relative rounded-2xl overflow-hidden shadow-xl border-4 border-white">
                    <img src="{{ asset('images/legis-building.jpg') }}"
                        class="w-full h-72 sm:h-80 md:h-96 object-cover group-hover:scale-105 transition-transform duration-700"
                        alt="Legislative Building">
                    <div class="absolute inset-0 bg-gradient-to-t from-green-950/60 to-transparent"></div>
                    <div class="absolute bottom-4 left-4">
                        <span class="bg-white/10 backdrop-blur-sm border border-white/20 text-white text-[10px] tracking-[2px] uppercase px-3 py-1.5 rounded-full">
                            Sangguniang Bayan
                        </span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- ══════════════════ MAP ══════════════════ --}}
<section class="bg-blue-950 py-20 px-4">

    <div class="max-w-6xl mx-auto">

        {{-- Header --}}
        <div class="text-center mb-12">
            <span class="inline-flex items-center gap-2 text-green-400 text-xs font-bold uppercase tracking-[0.3em] mb-4">
                <span class="w-8 h-px bg-green-400"></span>
                Find Us
                <span class="w-8 h-px bg-green-400"></span>
            </span>
            <h2 class="text-3xl sm:text-4xl font-bold text-white mb-3" style="font-family: 'Playfair Display', serif;">
                Legislative Building
            </h2>
            <p class="text-white/40 text-sm">Western Barangay, Hilongos, Leyte</p>
        </div>

        {{-- Info Strip --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
            <div class="bg-white/5 border border-white/10 rounded-2xl p-5 text-center hover:bg-white/10 transition-colors duration-300">
                <i class="fa-solid fa-location-dot text-green-400 text-xl mb-3 block"></i>
                <p class="text-white text-xs font-bold uppercase tracking-wide mb-1">Address</p>
                <p class="text-white/50 text-xs leading-relaxed">Western Barangay,<br>Hilongos, Leyte</p>
            </div>
            <div class="bg-white/5 border border-white/10 rounded-2xl p-5 text-center hover:bg-white/10 transition-colors duration-300">
                <i class="fa-solid fa-clock text-green-400 text-xl mb-3 block"></i>
                <p class="text-white text-xs font-bold uppercase tracking-wide mb-1">Office Hours</p>
                <p class="text-white/50 text-xs leading-relaxed">Monday – Friday<br>8:00 AM – 5:00 PM</p>
            </div>
            <div class="bg-white/5 border border-white/10 rounded-2xl p-5 text-center hover:bg-white/10 transition-colors duration-300">
                <i class="fa-solid fa-phone text-green-400 text-xl mb-3 block"></i>
                <p class="text-white text-xs font-bold uppercase tracking-wide mb-1">Contact</p>
                <p class="text-white/50 text-xs leading-relaxed">(+63) 954 305 6206</p>
            </div>
        </div>

        {{-- Map --}}
        <div class="rounded-2xl overflow-hidden shadow-2xl border-2 border-white/10">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3922.314987654321!2d124.7447686!3d10.3717315!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33076f38c5ea9443%3A0xc1f118b5152ba196!2sLegislative%20Building!5e0!3m2!1sen!2sph!4v1714440000000!5m2!1sen!2sph"
                class="w-full h-64 sm:h-80 md:h-[420px] lg:h-[480px] block"
                style="border:0;"
                allowfullscreen=""
                loading="lazy">
            </iframe>
        </div>

    </div>
</section>

@endsection
