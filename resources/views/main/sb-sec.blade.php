@extends('layout.layout')

@section('content')

{{-- ══════════════════ PAGE INTRO ══════════════════ --}}
<section class="bg-white border-b border-slate-100 py-12 px-4">
    <div class="max-w-5xl mx-auto">
        <div class="flex flex-col md:flex-row items-center gap-10 md:gap-16">

            {{-- Left: Text --}}
            <div class="flex-1 text-left">
                <span class="inline-block text-green-600 text-[11px] tracking-[0.35em] uppercase font-semibold mb-4">
                    Who Are We?
                </span>
                <h2 class="font-playfair text-blue-950 text-3xl sm:text-4xl md:text-5xl font-bold leading-tight mb-5">
                    Office of the Secretary<br class="hidden sm:block"> to the Sanggunian
                </h2>
                <div class="flex items-center gap-2 mb-5">
                    <span class="w-10 h-[3px] bg-green-500 block"></span>
                    <span class="w-3 h-[3px] bg-green-300 block"></span>
                </div>
                <p class="text-slate-600 text-sm sm:text-base leading-relaxed mb-4">
                    The <strong class="text-blue-950 font-semibold">Office of the Secretary to the Sanggunian</strong>
                    plays a crucial administrative and legislative support role within the Municipal government.
                </p>
                <p class="text-slate-500 text-sm leading-relaxed">
                    Serving the <strong class="text-blue-950 font-medium">Sangguniang Bayan of Hilongos, Leyte</strong>
                    through accurate documentation, transparent records management, and steadfast legislative support.
                </p>
            </div>

            {{-- Right: Image --}}
            <div class="flex-1 w-full">
                <img src="{{ asset('images/sb-sec.jpg') }}"
                    class="w-full h-auto object-contain block"
                    alt="Office of the Secretary to the Sanggunian">
            </div>

        </div>
    </div>
</section>

{{-- ══════════════════ FUNCTIONS ══════════════════ --}}
<section class="bg-slate-50 py-12 px-4">
    <div class="max-w-5xl mx-auto">

        <div class="mb-8">
            <span class="inline-block text-green-600 text-[11px] tracking-[0.35em] uppercase font-semibold mb-2">
                Mandate
            </span>
            <h3 class="font-playfair text-blue-950 text-2xl sm:text-3xl font-bold">
                Functions
            </h3>
        </div>

        @php
            $functions = [
                [
                    'icon'  => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z',
                    'label' => 'Legislative Facilitator',
                    'text'  => 'Ensure that all ordinances, resolutions and proceedings are properly documented, certified, archived and disseminated.',
                ],
                [
                    'icon'  => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z',
                    'label' => 'Administrative Coordinator',
                    'text'  => 'Handles communications, schedules meetings, prepares agendas and ensures that members of the Sangguniang Bayan are informed and supported in their legislative functions.',
                ],
                [
                    'icon'  => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2',
                    'label' => 'Records & Transparency',
                    'text'  => 'Upholds transparency and accountability by maintaining accurate and accessible records of council meetings, public hearings, and the like.',
                ],
            ];
        @endphp

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            @foreach ($functions as $fn)
            <div class="bg-white border border-slate-200 p-5 flex flex-col gap-3 hover:border-green-400 hover:shadow-sm transition-all duration-200">
                <div class="w-10 h-10 bg-green-50 border border-green-200 flex items-center justify-center flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $fn['icon'] }}" />
                    </svg>
                </div>
                <div>
                    <p class="text-blue-950 font-semibold text-xs uppercase tracking-wider mb-1">{{ $fn['label'] }}</p>
                    <p class="text-slate-600 text-sm leading-relaxed">{{ $fn['text'] }}</p>
                </div>
            </div>
            @endforeach
        </div>

    </div>
</section>

{{-- ══════════════════ MAJOR TARGETS ══════════════════ --}}
<section class="bg-blue-950 py-14 px-4">
    <div class="max-w-5xl mx-auto">

        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-3 mb-10">
            <div>
                <span class="inline-block text-green-300 text-[11px] tracking-[0.35em] uppercase font-semibold mb-2">
                    Looking Ahead
                </span>
                <h3 class="font-playfair text-white text-2xl sm:text-3xl md:text-4xl font-bold">
                    Major Targets in the Next Three Years
                </h3>
            </div>
            <p class="text-white/40 text-xs sm:text-sm sm:text-right max-w-xs">
                Key initiatives for modernization and legislative support
            </p>
        </div>

        @php
            $targets = [
                [
                    'title' => 'Full Digitalization of Legislative Records and Archives',
                    'items' => [
                        'Establish a digital records management system for ordinances, resolutions and minutes with supporting documents',
                        'Create an online database accessible to the public for transparency and easy search',
                        'Secure back-up systems for disaster recovery and data security',
                    ],
                ],
                [
                    'title' => 'Legislation Portal or Kiosk Installation',
                    'items' => [
                        'Set up a self-service kiosk at the Legislative Building for easy access to enacted ordinances and resolutions',
                    ],
                ],
                [
                    'title' => 'Capacity Support for Barangay Legislative Secretaries',
                    'items' => [
                        'Conduct training or quarterly workshops for Barangay Secretaries on legislative documentation, formatting of resolutions and proper archiving',
                    ],
                ],
                [
                    'title' => 'Assistance in the Establishment of Barangay Reading Centers',
                    'items' => [
                        'Facilitation in the accreditation of fifty-one (51) Barangay Reading Centers',
                    ],
                ],
            ];
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach ($targets as $target)
            <div class="border border-white/10 bg-white/5 p-5">
                <h4 class="text-green-300 text-[10px] tracking-[0.25em] uppercase font-bold mb-3 pb-2 border-b border-white/10">
                    {{ $target['title'] }}
                </h4>
                <ul class="space-y-2">
                    @foreach ($target['items'] as $item)
                    <li class="flex items-start gap-2">
                        <span class="text-green-400 flex-shrink-0 mt-0.5 font-bold text-xs">▸</span>
                        <span class="text-white/65 text-xs leading-snug">{{ $item }}</span>
                    </li>
                    @endforeach
                </ul>
            </div>
            @endforeach
        </div>

    </div>
</section>

{{-- ══════════════════ CHALLENGES & SUGGESTED ACTIONS ══════════════════ --}}
<section class="bg-slate-50 py-14 px-4">
    <div class="max-w-5xl mx-auto">

        <div class="mb-10 text-center">
            <span class="inline-block text-green-600 text-[11px] tracking-[0.35em] uppercase font-semibold mb-2">
                Governance Outlook
            </span>
            <h3 class="font-playfair text-blue-950 text-2xl sm:text-3xl md:text-4xl font-bold">
                Challenges &amp; Suggested Actions
            </h3>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- Challenges --}}
            <div class="bg-white border border-slate-200 p-6">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-8 h-8 bg-red-50 border border-red-200 flex items-center justify-center flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                        </svg>
                    </div>
                    <h4 class="font-playfair text-blue-950 text-lg font-bold">Major Challenges</h4>
                </div>

                <div class="space-y-4">
                    <div class="border-l-2 border-red-400/60 pl-4">
                        <p class="text-blue-950 text-sm font-semibold mb-1">Funding Constraints / Insufficient Budget Allocation</p>
                        <ul class="space-y-1 mt-2">
                            @foreach ([
                                'Digitization projects require initial investment in hardware, software, storage as well as maintenance costs for licenses, upgrades and equipment replacement',
                                'Most barangays operate with small budgets and barangay reading centers are not usually prioritized in Annual / Supplemental Budgets',
                            ] as $item)
                            <li class="flex items-start gap-2 text-slate-500 text-xs leading-snug">
                                <span class="text-red-400 flex-shrink-0 mt-0.5">▸</span>
                                <span>{{ $item }}</span>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="border-l-2 border-red-400/60 pl-4">
                        <p class="text-blue-950 text-sm font-semibold mb-1">Risk Mitigation</p>
                        <ul class="space-y-1 mt-2">
                            @foreach ([
                                'Low digital literacy among staff',
                                'Lack of in-house IT personnel to design, deploy and maintain the portal or kiosk system',
                                'Poor equipment and infrastructure at the Barangay level',
                                'Data security / cyber security risks',
                                'Connectivity and accessibility issues',
                            ] as $item)
                            <li class="flex items-start gap-2 text-slate-500 text-xs leading-snug">
                                <span class="text-red-400 flex-shrink-0 mt-0.5">▸</span>
                                <span>{{ $item }}</span>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            {{-- Suggested Actions --}}
            <div class="bg-white border border-slate-200 p-6">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-8 h-8 bg-green-50 border border-green-200 flex items-center justify-center flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h4 class="font-playfair text-blue-950 text-lg font-bold">Suggested Actions</h4>
                </div>

                @php
                    $actions = [
                        [
                            'group' => 'Secure Policy Support',
                            'items' => [
                                'An ordinance for the creation of Local Legislative Staff Officer III',
                            ],
                        ],
                        [
                            'group' => 'Digital Governance',
                            'items' => [
                                'Procurement and installation of Legislation Portal or Kiosk',
                                'Procurement of additional desktop computers',
                                'Establishment of legislative website',
                            ],
                        ],
                    ];
                @endphp

                <div class="space-y-4">
                    @foreach ($actions as $i => $action)
                    <div class="border-l-2 border-green-400/60 pl-4">
                        <p class="text-blue-950 text-sm font-semibold mb-2">{{ $action['group'] }}</p>
                        <ul class="space-y-1">
                            @foreach ($action['items'] as $j => $item)
                            <li class="flex items-start gap-2">
                                <span class="flex-shrink-0 w-4 h-4 bg-green-50 border border-green-200 text-green-600 text-[9px] font-bold flex items-center justify-center mt-0.5">
                                    {{ $j + 1 }}
                                </span>
                                <span class="text-slate-600 text-xs leading-snug">{{ $item }}</span>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</section>

@endsection
