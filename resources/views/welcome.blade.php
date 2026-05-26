@extends('layout.layout')

@section('content')
    <div class="bg-slate-50 py-16 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">

            {{-- ═════════ SECTION HEADER ═════════ --}}
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 mb-10">

                <div class="flex items-center gap-3">
                    <div class="h-px w-10 bg-blue-800/30"></div>
                    <span class="text-blue-800 text-xs font-bold uppercase tracking-[0.3em]">
                        Latest Updates
                    </span>
                    <div class="h-px w-10 bg-blue-800/30"></div>
                </div>

                <div class="flex items-center gap-2 bg-white border border-blue-100 rounded-full px-4 py-2 shadow-sm">
                    <div class="w-2 h-2 rounded-full bg-[#1877f2] animate-pulse"></div>
                    <span class="text-xs font-bold text-blue-700 tracking-wide">
                        FB: @SBHilongos
                    </span>
                </div>

            </div>

            {{-- ═════════ MAIN GRID ═════════ --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                {{-- ═════════ LEFT: FACEBOOK EMBED ═════════ --}}
                <div
                    class="hidden lg:flex flex-col bg-white rounded-2xl shadow-md border border-slate-200 overflow-hidden self-start sticky top-6">

                    {{-- Facebook Header --}}
                    <div class="flex items-center gap-3 px-5 py-4 border-b border-slate-100">

                        <div class="w-9 h-9 rounded-full bg-[#1877f2] flex items-center justify-center">
                            <i class="fa-brands fa-facebook-f text-white text-sm"></i>
                        </div>

                        <div>
                            <p class="text-sm font-bold text-slate-800">SB Hilongos Official</p>
                            <p class="text-xs text-slate-400">Facebook Page Timeline</p>
                        </div>

                        <a href="https://www.facebook.com/SBHilongos/" target="_blank"
                            class="ml-auto text-xs font-semibold text-[#1877f2] hover:underline">
                            Visit Page
                            <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                        </a>

                    </div>

                    {{-- Facebook Embed --}}
                    <div style="height: 700px; overflow: hidden;">
                        <iframe
                            src="https://www.facebook.com/plugins/page.php?href=https://www.facebook.com/SBHilongos/&tabs=timeline&width=500&height=700&small_header=false&adapt_container_width=true&hide_cover=false&show_facepile=true"
                            style="width: 100%; height: 100%; border: none; overflow: hidden;" scrolling="yes"
                            frameborder="0" allowfullscreen="true"
                            allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share">
                        </iframe>
                    </div>

                </div>

                {{-- ═════════ RIGHT SIDE CONTENT ═════════ --}}
                <div class="flex flex-col gap-5 h-full">

                    {{-- ═════════ SB MEMBERS CARD ═════════ --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">

                        <div class="relative h-64 sm:h-80">
                            <img src="{{ asset('images/SB-Members.jpg') }}" class="w-full h-full object-cover"
                                alt="SB Members">
                            <div class="absolute inset-0 bg-gradient-to-t from-blue-950/90 via-blue-900/40 to-transparent">
                            </div>
                            <div class="absolute bottom-0 p-6">
                                <span
                                    class="bg-green-500/20 border border-green-400/40 text-green-300 text-[10px] uppercase px-3 py-1 rounded-full">
                                    SB Members
                                </span>
                                <h3 class="text-white text-xl font-bold mt-3"
                                    style="font-family: 'Playfair Display', serif;">
                                    Seventeenth Sangguniang Bayan of Hilongos
                                </h3>
                            </div>
                        </div>

                        <div class="p-6 flex flex-col gap-4">

                            <div class="flex items-center gap-3">
                                <div class="w-1 h-8 bg-green-400 rounded-full"></div>
                                <h4 class="text-blue-900 font-bold">WHO ARE WE?</h4>
                            </div>

                            <p class="text-slate-500 text-sm leading-7 text-justify">
                                The Sangguniang Bayan is the legislative body responsible for creating ordinances,
                                resolutions, and policies that support local governance and development.
                            </p>

                            <div class="grid grid-cols-2 gap-2">
                                <div class="bg-slate-50 rounded-xl p-4 text-center border border-slate-200">
                                    <p class="text-2xl font-extrabold text-blue-800">{{ $membersCount }}</p>
                                    <p class="text-[10px] uppercase tracking-widest text-slate-400 mt-1">Councilors</p>
                                </div>
                                <div class="bg-slate-50 rounded-xl p-4 text-center border border-slate-200">
                                    <p class="text-sm font-extrabold text-blue-800 leading-tight">Every<br>Monday</p>
                                    <p class="text-[10px] uppercase tracking-widest text-slate-400 mt-1">Sessions</p>
                                </div>
                            </div>

                            <div class="pt-1 border-t border-slate-100">
                                <a href="{{ route('sb.info') }}"
                                    class="flex items-center justify-center gap-2 w-full py-2.5 text-sm font-semibold text-white bg-green-600 hover:bg-green-500 transition duration-200 rounded-lg">
                                    Learn More
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                                    </svg>
                                </a>
                            </div>

                        </div>
                    </div>

                    {{-- ═════════ SB SECRETARY CARD ═════════ --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">

                        <div class="relative h-64 sm:h-80">
                            <img src="{{ asset('images/SB-Sec.jpg') }}" class="w-full h-full object-cover"
                                alt="SB Secretary">
                            <div class="absolute inset-0 bg-gradient-to-t from-blue-950/90 via-blue-900/40 to-transparent">
                            </div>
                            <div class="absolute bottom-0 p-6">
                                <span
                                    class="bg-green-500/20 border border-green-400/40 text-green-300 text-[10px] uppercase px-3 py-1 rounded-full">
                                    SB Secretary
                                </span>
                                <h3 class="text-white text-xl font-bold mt-3"
                                    style="font-family: 'Playfair Display', serif;">
                                    Legislative Support Office
                                </h3>
                            </div>
                        </div>

                        <div class="p-6 flex flex-col gap-4">

                            <div class="flex items-center gap-3">
                                <div class="w-1 h-8 bg-green-400 rounded-full"></div>
                                <h4 class="text-blue-900 font-bold">WHO ARE WE?</h4>
                            </div>

                            <p class="text-slate-500 text-sm leading-7 text-justify">
                                The Office of the Secretary provides administrative and legislative support to ensure
                                efficient governance and documentation.
                            </p>

                            <div class="flex flex-wrap gap-2 pb-1">
                                <span
                                    class="flex items-center gap-1.5 bg-blue-50 text-blue-700 text-xs font-semibold px-3 py-1.5 rounded-full">
                                    <i class="fa-solid fa-landmark text-[10px]"></i> Local Governance
                                </span>
                                <span
                                    class="flex items-center gap-1.5 bg-blue-50 text-blue-700 text-xs font-semibold px-3 py-1.5 rounded-full">
                                    <i class="fa-solid fa-location-dot text-[10px]"></i> Hilongos, Leyte
                                </span>
                                <span
                                    class="flex items-center gap-1.5 bg-green-50 text-green-700 text-xs font-semibold px-3 py-1.5 rounded-full">
                                    <i class="fa-solid fa-scale-balanced text-[10px]"></i> Legislative
                                </span>
                            </div>

                            <div class="pt-1 border-t border-slate-100">
                                <a href="{{ route('sb.sec') }}"
                                    class="flex items-center justify-center gap-2 w-full py-2.5 text-sm font-semibold text-white bg-green-600 hover:bg-green-500 transition duration-200 rounded-lg">
                                    Learn More
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                                    </svg>
                                </a>
                            </div>

                        </div>
                    </div>

                    {{-- ═════════ RECORD TYPES ═════════ --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">

                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-1 h-8 bg-green-400 rounded-full"></div>
                            <h4 class="text-blue-900 font-bold">
                                Types of Information and Records
                            </h4>
                        </div>

                        <div class="flex flex-wrap gap-3 pt-5 border-t border-slate-200">

                            {{-- ORBOS --}}
                            <span
                                class="flex items-center gap-2 bg-blue-50 text-blue-700 text-xs font-semibold px-4 py-2 rounded-full shadow-sm">
                                <i class="fa-solid fa-list-ol text-[11px]"></i>
                                ORBOS
                            </span>

                            {{-- Ordinance --}}
                            <span
                                class="flex items-center gap-2 bg-green-50 text-green-700 text-xs font-semibold px-4 py-2 rounded-full shadow-sm">
                                <i class="fa-solid fa-file-lines text-[11px]"></i>
                                Ordinance
                            </span>

                            {{-- Announcements --}}
                            <span
                                class="flex items-center gap-2 bg-yellow-50 text-yellow-700 text-xs font-semibold px-4 py-2 rounded-full shadow-sm">
                                <i class="fa-solid fa-bullhorn text-[11px]"></i>
                                Announcements
                            </span>

                            {{-- SB Members --}}
                            <span
                                class="flex items-center gap-2 bg-violet-50 text-violet-700 text-xs font-semibold px-4 py-2 rounded-full shadow-sm">
                                <i class="fa-solid fa-users text-[11px]"></i>
                                SB Members
                            </span>

                            {{-- Former SB Members --}}
                            <span
                                class="flex items-center gap-2 bg-orange-50 text-orange-700 text-xs font-semibold px-4 py-2 rounded-full shadow-sm">
                                <i class="fa-solid fa-user-clock text-[11px]"></i>
                                Former SB Members
                            </span>

                            {{-- Citizens Charter --}}
                            <span
                                class="flex items-center gap-2 bg-teal-50 text-teal-700 text-xs font-semibold px-4 py-2 rounded-full shadow-sm">
                                <i class="fa-solid fa-clipboard-list text-[11px]"></i>
                                Citizens Charter
                            </span>

                            {{-- Organizational Chart --}}
                            <span
                                class="flex items-center gap-2 bg-pink-50 text-pink-700 text-xs font-semibold px-4 py-2 rounded-full shadow-sm">
                                <i class="fa-solid fa-sitemap text-[11px]"></i>
                                Organizational Chart
                            </span>

                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
