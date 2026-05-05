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
            News & Updates
        </h1>
        <p class="text-white/50 text-sm leading-relaxed max-w-md mx-auto">
            Stay connected with the latest activities and announcements from the Sangguniang Bayan of Hilongos, Leyte.
        </p>
    </div>
</div>

{{-- ══════════════════ MAIN CONTENT ══════════════════ --}}
<div class="bg-slate-50 py-16 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">

        {{-- Section Label --}}
        <div class="flex items-center justify-between flex-wrap gap-4 mb-10">
            <div class="flex items-center gap-3">
                <div class="h-px w-10 bg-blue-800/30"></div>
                <span class="text-blue-800 text-xs font-bold uppercase tracking-[0.3em]">Latest Updates</span>
                <div class="h-px w-10 bg-blue-800/30"></div>
            </div>
            <div class="flex items-center gap-2 bg-white border border-blue-100 rounded-full px-4 py-2 shadow-sm">
                <div class="w-2 h-2 rounded-full bg-[#1877f2] animate-pulse"></div>
                <span class="text-xs font-bold text-blue-700 tracking-wide">@SBHilongos</span>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">

            {{-- ══ LEFT: FACEBOOK EMBED ══ --}}
            <div class="bg-white rounded-2xl shadow-md border border-slate-200 overflow-hidden flex flex-col">

                {{-- Card Header --}}
                <div class="flex items-center gap-3 px-5 py-4 border-b border-slate-100">
                    <div class="w-9 h-9 rounded-full bg-[#1877f2] flex items-center justify-center flex-shrink-0">
                        <i class="fa-brands fa-facebook-f text-white text-sm"></i>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-slate-800 leading-tight">SB Hilongos Official</p>
                        <p class="text-xs text-slate-400">Facebook Page Timeline</p>
                    </div>
                    <a href="https://www.facebook.com/SBHilongos/" target="_blank"
                        class="ml-auto flex items-center gap-1.5 text-xs font-semibold text-[#1877f2] hover:underline">
                        Visit Page <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                    </a>
                </div>

                {{-- Embed --}}
                <div class="flex-1">
                    <iframe
                        src="https://www.facebook.com/plugins/page.php?href=https://www.facebook.com/SBHilongos/&tabs=timeline&width=500&height=800&small_header=false&adapt_container_width=true&hide_cover=false&show_facepile=true"
                        class="w-full block"
                        height="780"
                        style="border:none; overflow:hidden;"
                        scrolling="yes"
                        frameborder="0"
                        allowfullscreen="true"
                        allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share">
                    </iframe>
                </div>
            </div>

            {{-- ══ RIGHT: BUILDING INFO ══ --}}
            <div class="flex flex-col gap-5">

                {{-- Building Image Card --}}
                <div class="relative w-full h-64 sm:h-80 rounded-2xl overflow-hidden shadow-md group">
                    <img src="{{ asset('images/legis-building.jpg') }}"
                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700"
                        alt="Legislative Building">
                    <div class="absolute inset-0 bg-gradient-to-t from-blue-950/90 via-blue-900/40 to-transparent"></div>

                    {{-- Overlay Text --}}
                    <div class="absolute bottom-0 left-0 right-0 p-6">
                        <span class="inline-block bg-green-500/20 border border-green-400/40 text-green-300
                                     text-[10px] tracking-[2px] uppercase px-3 py-1 rounded-full mb-3">
                            Legislative Seat
                        </span>
                        <h3 class="text-white text-xl sm:text-2xl font-bold leading-tight" style="font-family: 'Playfair Display', serif;">
                            Hilongos Legislative Building
                        </h3>
                        <p class="text-white/60 text-xs mt-1">Western Barangay, Hilongos, Leyte</p>
                    </div>
                </div>

                {{-- Stats Row --}}
                <div class="grid grid-cols-3 gap-3">
                    <div class="bg-white rounded-2xl p-4 text-center shadow-sm border border-slate-200 hover:border-blue-300 hover:shadow-md transition-all duration-300">
                        <p class="text-2xl font-extrabold text-blue-800">{{ $membersCount }}</p>
                        <p class="text-[10px] uppercase tracking-widest text-slate-400 mt-1">Councilors</p>
                    </div>
                    <div class="bg-white rounded-2xl p-4 text-center shadow-sm border border-slate-200 hover:border-blue-300 hover:shadow-md transition-all duration-300">
                        <p class="text-sm font-extrabold text-blue-800 leading-tight">Every<br>Monday</p>
                        <p class="text-[10px] uppercase tracking-widest text-slate-400 mt-1">Sessions</p>
                    </div>
                    <div class="bg-white rounded-2xl p-4 text-center shadow-sm border border-slate-200 hover:border-blue-300 hover:shadow-md transition-all duration-300">
                        <p class="text-sm font-extrabold text-blue-800 leading-tight">Hilongos<br>LGU</p>
                        <p class="text-[10px] uppercase tracking-widest text-slate-400 mt-1">Local Gov</p>
                    </div>
                </div>

                {{-- Description Card --}}
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 flex-1">

                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-1 h-8 rounded-full bg-green-400"></div>
                        <h4 class="text-blue-900 font-bold text-base">About the Building</h4>
                    </div>

                    <p class="text-slate-500 leading-7 text-sm text-justify">
                        The Hilongos Legislative Building stands as a symbol of local democracy,
                        offering a structured environment where the town's legislative body crafts
                        policies for the community's welfare. Its strategic position near the municipal
                        hall ensures seamless coordination between the executive and legislative branches
                        of the local government. By providing modern facilities for sessions and committee
                        meetings, the building plays a crucial role in transparent, responsive, and
                        efficient governance for the people of Hilongos.
                    </p>

                    {{-- Tags --}}
                    <div class="flex flex-wrap gap-2 mt-5 pt-5 border-t border-slate-100">
                        <span class="flex items-center gap-1.5 bg-blue-50 text-blue-700 text-xs font-semibold px-3 py-1.5 rounded-full">
                            <i class="fa-solid fa-landmark text-[10px]"></i> Local Governance
                        </span>
                        <span class="flex items-center gap-1.5 bg-blue-50 text-blue-700 text-xs font-semibold px-3 py-1.5 rounded-full">
                            <i class="fa-solid fa-location-dot text-[10px]"></i> Hilongos, Leyte
                        </span>
                        <span class="flex items-center gap-1.5 bg-green-50 text-green-700 text-xs font-semibold px-3 py-1.5 rounded-full">
                            <i class="fa-solid fa-scale-balanced text-[10px]"></i> Legislative
                        </span>
                    </div>

                </div>

                {{-- CTA --}}
                <a href="{{ route('legislative_index') }}"
                    class="flex items-center justify-center gap-2 w-full bg-blue-800 hover:bg-blue-700
                           text-white text-xs font-bold uppercase tracking-widest py-4 rounded-2xl
                           transition-all duration-300 hover:-translate-y-0.5 shadow-md hover:shadow-lg shadow-blue-800/30">
                    <i class="fa-solid fa-file-lines"></i>
                    View Legislative Records
                </a>

            </div>
        </div>
    </div>
</div>

@endsection
