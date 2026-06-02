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
            Activities & Gallery
        </h1>
        <p class="text-white/50 text-sm leading-relaxed max-w-md mx-auto">
            A visual record of the Sangguniang Bayan's conducted activities, public hearings, sessions, and offices.
        </p>
    </div>
</div>

<div class="py-16 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-12">

        {{-- ══════════════════ TABS ══════════════════ --}}
        <div class="flex flex-wrap justify-center gap-2 sm:gap-3 mb-12">

            @php
                $tabs = [
                    ['key' => 'all',       'label' => 'All',               'icon' => 'fa-grip'],
                    ['key' => 'public',    'label' => 'Public Hearings',   'icon' => 'fa-people-group'],
                    ['key' => 'regular',   'label' => 'Regular Session',   'icon' => 'fa-landmark'],
                    ['key' => 'committee', 'label' => 'Committee Meetings','icon' => 'fa-handshake'],
                    ['key' => 'offices',   'label' => 'Offices Directory', 'icon' => 'fa-building'],
                ];
            @endphp

            @foreach ($tabs as $tab)
                <button
                    class="tab-btn flex items-center gap-2 px-4 sm:px-5 py-2.5 rounded-full text-xs font-bold uppercase tracking-wider transition-all duration-300
                           {{ $tab['key'] === 'all'
                               ? 'bg-blue-800 text-white shadow-md shadow-blue-800/30'
                               : 'bg-white text-slate-500 border border-slate-200 hover:border-blue-800 hover:text-blue-800' }}"
                    data-tab="{{ $tab['key'] }}">
                    <i class="fa-solid {{ $tab['icon'] }} text-sm"></i>
                    {{ $tab['label'] }}
                </button>
            @endforeach

        </div>

        {{-- ══════════════════ IMAGE CARDS MACRO ══════════════════ --}}
        @php
            $publicImages = [
                ['src' => 'images/Hearings/hearing1.jpg', 'title' => 'Public Hearing Session',         'desc' => 'Community members gathered to discuss local ordinances and public concerns.'],
                ['src' => 'images/Hearings/hearing2.jpg', 'title' => 'Open Forum',                     'desc' => 'Citizens voice their concerns directly to the Sangguniang Bayan members.'],
                ['src' => 'images/Hearings/hearing3.jpg', 'title' => 'Community Consultation',         'desc' => 'Barangay representatives participate in a scheduled public consultation.'],
            ];

            $regularImages = [
                ['src' => 'images/Regular/March-9-2026-10th-Regular-Session-CY-2026.jpg', 'title' => 'March 9 - 10th Regular Session CY 2026',        'desc' => 'The SB convenes for its regular weekly session to deliberate on proposed measures.'],
                ['src' => 'images/Regular/April-6-14th-Regular-Session-CY-2026.jpg', 'title' => 'April 6 - 14th Regular Session CY 2026',    'desc' => 'SB members actively review and debate legislative proposals on the floor.'],
                ['src' => 'images/Regular/May-4-18th-Regular-Session-CY-2026.jpg', 'title' => 'May 4 - 18th Regular Session CY 2026',            'desc' => 'Session begins with roll call to establish quorum before proceeding.'],
            ];

            $committeeImages = [
                ['src' => 'images/Committee/committee1.jpg', 'title' => 'Committee on Public Safety and Order, Public Utilities and Transportation',        'desc' => 'Reviews matters related to public safety, transportation, traffic management, and public utilities to promote community welfare and efficient services.'],
                ['src' => 'images/Committee/committee2.jpg', 'title' => 'Committee on Housing, Land Use, Planning and Development',         'desc' => 'Reviews matters related to housing, land use, planning, and development to promote sustainable growth and improved community living.'],
                ['src' => 'images/Committee/committee3.jpg', 'title' => 'Committee on Infrastructure', 'desc' => 'Assessment of road, drainage, and public works improvement proposals.'],
            ];

            $officeImages = [
                ['src' => 'images/Offices/Vice-Mayor-Office.jpg',        'title' => "Vice Mayor's Office",          'desc' => 'Office of the Presiding Officer of the Sangguniang Bayan.'],
                ['src' => 'images/Offices/Office-Sectretary.jpg',   'title' => "SB Secretariat Office",      'desc' => 'Office of the Secretariat to the Sangguniang Bayan.'],
                ['src' => 'images/Offices/SB-Member-Offices.jpg', 'title' => "SB Member Offices",      'desc' => 'SB Members who are Responsible for legislative records, minutes, and official SB documents.'],
                ['src' => 'images/Offices/Record-Section.jpg',       'title' => 'Record Section',            'desc' => 'The Office Responsible for the Lifecycle of the entire Document of the Sanggunian'],
                ['src' => 'images/Offices/SB-Session-Hall.jpg',  'title' => 'Sangguniang Bayan Session Hall',       'desc' => 'SB Official Chamber where the Sangguniang Bayan Meets to Conduct its Business'],
                ['src' => 'images/Offices/Hon-Loreto-Hall.jpg',     'title' => 'Hon. Loreto P. Lora Hall',          'desc' => 'Committee Meetings and Public Hearing are Conducted'],
                ['src' => 'images/Library/Library-1.jpg', 'title' => 'Municipal Library', 'desc' => ''],
                ['src' => 'images/Library/Library-2.jpg', 'title' => 'Municipal Library', 'desc' => ''],
                ['src' => 'images/Library/Library-3.jpg', 'title' => 'Municipal Library', 'desc' => ''],
            ];

            $allImages = array_merge($publicImages, $regularImages, $committeeImages, $officeImages);
        @endphp

        {{-- Helper: image card --}}
        @php
            function renderCards($images) {
                $html = '';
                foreach ($images as $img) {
                    $html .= '
                    <div class="group relative overflow-hidden rounded-2xl shadow-md hover:shadow-xl transition-shadow duration-300 bg-white">
                        <div class="relative overflow-hidden aspect-[4/3]">
                            <img src="' . asset($img['src']) . '"
                                 alt="' . e($img['title']) . '"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-blue-950/90 via-blue-900/30 to-transparent
                                        translate-y-4 opacity-0 group-hover:opacity-100 group-hover:translate-y-0
                                        transition-all duration-400"></div>
                            <div class="absolute bottom-0 left-0 right-0 p-4
                                        translate-y-4 opacity-0 group-hover:opacity-100 group-hover:translate-y-0
                                        transition-all duration-400">
                                <p class="text-white/80 text-xs leading-relaxed">' . e($img['desc']) . '</p>
                            </div>
                        </div>
                        <div class="p-4 border-t-2 border-green-400">
                            <h3 class="text-blue-900 font-bold text-sm">' . e($img['title']) . '</h3>
                        </div>
                    </div>';
                }
                return $html;
            }
        @endphp

        {{-- ALL --}}
        <div class="tab-content grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6" id="all">
            @foreach ($allImages as $img)
                <div class="group relative overflow-hidden rounded-2xl shadow-md hover:shadow-xl transition-shadow duration-300 bg-white">
                    <div class="relative overflow-hidden aspect-[4/3]">
                        <img src="{{ asset($img['src']) }}" alt="{{ $img['title'] }}"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-blue-950/90 via-blue-900/30 to-transparent
                                    opacity-0 group-hover:opacity-100 translate-y-2 group-hover:translate-y-0
                                    transition-all duration-500"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-4
                                    opacity-0 group-hover:opacity-100 translate-y-2 group-hover:translate-y-0
                                    transition-all duration-500 delay-75">
                            <p class="text-white/80 text-xs leading-relaxed">{{ $img['desc'] }}</p>
                        </div>
                    </div>
                    <div class="p-4 border-t-2 border-green-400">
                        <h3 class="text-blue-900 font-bold text-sm">{{ $img['title'] }}</h3>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- PUBLIC --}}
        <div class="tab-content hidden grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6" id="public">
            @foreach ($publicImages as $img)
                <div class="group relative overflow-hidden rounded-2xl shadow-md hover:shadow-xl transition-shadow duration-300 bg-white">
                    <div class="relative overflow-hidden aspect-[4/3]">
                        <img src="{{ asset($img['src']) }}" alt="{{ $img['title'] }}"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-blue-950/90 via-blue-900/30 to-transparent
                                    opacity-0 group-hover:opacity-100 translate-y-2 group-hover:translate-y-0
                                    transition-all duration-500"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-4
                                    opacity-0 group-hover:opacity-100 translate-y-2 group-hover:translate-y-0
                                    transition-all duration-500 delay-75">
                            <p class="text-white/80 text-xs leading-relaxed">{{ $img['desc'] }}</p>
                        </div>
                    </div>
                    <div class="p-4 border-t-2 border-green-400">
                        <h3 class="text-blue-900 font-bold text-sm">{{ $img['title'] }}</h3>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- REGULAR --}}
        <div class="tab-content hidden grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6" id="regular">
            @foreach ($regularImages as $img)
                <div class="group relative overflow-hidden rounded-2xl shadow-md hover:shadow-xl transition-shadow duration-300 bg-white">
                    <div class="relative overflow-hidden aspect-[4/3]">
                        <img src="{{ asset($img['src']) }}" alt="{{ $img['title'] }}"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-blue-950/90 via-blue-900/30 to-transparent
                                    opacity-0 group-hover:opacity-100 translate-y-2 group-hover:translate-y-0
                                    transition-all duration-500"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-4
                                    opacity-0 group-hover:opacity-100 translate-y-2 group-hover:translate-y-0
                                    transition-all duration-500 delay-75">
                            <p class="text-white/80 text-xs leading-relaxed">{{ $img['desc'] }}</p>
                        </div>
                    </div>
                    <div class="p-4 border-t-2 border-green-400">
                        <h3 class="text-blue-900 font-bold text-sm">{{ $img['title'] }}</h3>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- COMMITTEE --}}
        <div class="tab-content hidden grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6" id="committee">
            @foreach ($committeeImages as $img)
                <div class="group relative overflow-hidden rounded-2xl shadow-md hover:shadow-xl transition-shadow duration-300 bg-white">
                    <div class="relative overflow-hidden aspect-[4/3]">
                        <img src="{{ asset($img['src']) }}" alt="{{ $img['title'] }}"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-blue-950/90 via-blue-900/30 to-transparent
                                    opacity-0 group-hover:opacity-100 translate-y-2 group-hover:translate-y-0
                                    transition-all duration-500"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-4
                                    opacity-0 group-hover:opacity-100 translate-y-2 group-hover:translate-y-0
                                    transition-all duration-500 delay-75">
                            <p class="text-white/80 text-xs leading-relaxed">{{ $img['desc'] }}</p>
                        </div>
                    </div>
                    <div class="p-4 border-t-2 border-green-400">
                        <h3 class="text-blue-900 font-bold text-sm">{{ $img['title'] }}</h3>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- OFFICES --}}
        <div class="tab-content hidden grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6" id="offices">
            @foreach ($officeImages as $img)
                <div class="group relative overflow-hidden rounded-2xl shadow-md hover:shadow-xl transition-shadow duration-300 bg-white">
                    <div class="relative overflow-hidden aspect-[4/3]">
                        <img src="{{ asset($img['src']) }}" alt="{{ $img['title'] }}"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-blue-950/90 via-blue-900/30 to-transparent
                                    opacity-0 group-hover:opacity-100 translate-y-2 group-hover:translate-y-0
                                    transition-all duration-500"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-4
                                    opacity-0 group-hover:opacity-100 translate-y-2 group-hover:translate-y-0
                                    transition-all duration-500 delay-75">
                            <p class="text-white/80 text-xs leading-relaxed">{{ $img['desc'] }}</p>
                        </div>
                    </div>
                    <div class="p-4 border-t-2 border-green-400">
                        <h3 class="text-blue-900 font-bold text-sm">{{ $img['title'] }}</h3>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const tabs = document.querySelectorAll('.tab-btn');
        const panels = document.querySelectorAll('.tab-content');

        const activeClasses   = ['bg-blue-800', 'text-white', 'shadow-md', 'shadow-blue-800/30'];
        const inactiveClasses = ['bg-white', 'text-slate-500', 'border', 'border-slate-200', 'hover:border-blue-800', 'hover:text-blue-800'];

        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                const target = tab.dataset.tab;

                // Update tab styles
                tabs.forEach(t => {
                    t.classList.remove(...activeClasses);
                    t.classList.add(...inactiveClasses);
                });
                tab.classList.remove(...inactiveClasses);
                tab.classList.add(...activeClasses);

                // Show/hide panels
                panels.forEach(panel => {
                    if (panel.id === target) {
                        panel.classList.remove('hidden');
                    } else {
                        panel.classList.add('hidden');
                    }
                });
            });
        });
    });
</script>
@endpush
