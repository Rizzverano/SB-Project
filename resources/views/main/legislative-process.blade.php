@extends('layout.layout')

@section('content')

{{-- ══════════════════ PAGE HERO ══════════════════ --}}
<div class="relative bg-gradient-to-br from-blue-950 via-blue-900 to-slate-900 py-20 px-4 overflow-hidden">
    {{-- Decorative rings --}}
    <div class="absolute top-0 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] rounded-full border border-white/5"></div>
    <div class="absolute top-0 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[400px] h-[400px] rounded-full border border-white/5"></div>
    <div class="absolute -bottom-24 -right-24 w-64 h-64 rounded-full bg-green-500/10 blur-3xl"></div>
    <div class="absolute -top-12 -left-12 w-48 h-48 rounded-full bg-blue-400/10 blur-2xl"></div>

    <div class="relative z-10 text-center max-w-2xl mx-auto">
        <span class="inline-block text-green-400 text-xs tracking-[0.4em] uppercase font-semibold mb-4">
            Hilongos, Leyte • LGU
        </span>
        <h1 class="text-white text-4xl sm:text-5xl font-bold leading-tight mb-4" style="font-family: 'Playfair Display', serif;">
            Legislative Process
        </h1>
        <p class="text-white/50 text-sm leading-relaxed max-w-md mx-auto">
            The official step-by-step flowchart of enacting ordinances and resolutions of the Sangguniang Bayan.
        </p>
    </div>
</div>

{{-- ══════════════════ MAIN CONTENT ══════════════════ --}}
<div class="bg-slate-50 py-14 px-4 sm:px-6 lg:px-8 min-h-screen">
    <div class="max-w-5xl mx-auto">

        {{-- ══ SECTION LABEL ══ --}}
        <div class="text-center mb-12">
            <span class="inline-block text-blue-800 text-xs tracking-[0.3em] uppercase font-bold
                         border border-blue-200 bg-blue-50 rounded-full px-4 py-1.5 mb-3">
                Official Procedure
            </span>
            <h2 class="text-blue-900 text-2xl sm:text-3xl font-bold" style="font-family: 'Playfair Display', serif;">
                Legislative Flowchart
            </h2>
            <p class="text-slate-400 text-sm mt-2">12-step process from filing to final review</p>
            <div class="w-14 h-0.5 bg-gradient-to-r from-blue-800 to-transparent mx-auto mt-4 rounded-full"></div>
        </div>

        {{-- ══ TIMELINE ══ --}}
        @php
            $steps = [
                ['label' => 'Filing of Proposed Ordinance / Resolution',                   'icon' => 'fa-file-circle-plus'],
                ['label' => 'First Reading / Referral to Appropriate Committee',            'icon' => 'fa-book-open'],
                ['label' => 'Public Hearing / Committee Meeting / Action',                  'icon' => 'fa-users'],
                ['label' => 'Committee Report',                                             'icon' => 'fa-file-lines'],
                ['label' => 'Proposed Measures for Inclusion in the Calendar of Business', 'icon' => 'fa-calendar-days'],
                ['label' => 'Second Reading',                                               'icon' => 'fa-book-bookmark'],
                ['label' => 'Printing of Final Draft by the Secretary to the Sangguniang', 'icon' => 'fa-print'],
                ['label' => 'Third and Final Reading',                                      'icon' => 'fa-check-double'],
                ['label' => 'Signing of Enacted Ordinance and Approved Resolution',         'icon' => 'fa-pen-nib'],
                ['label' => "10-Day Period for Mayor's Approval",                           'icon' => 'fa-clock'],
                ['label' => '3-Day Submission to Sangguniang Panlalawigan',                 'icon' => 'fa-paper-plane'],
                ['label' => 'Review Period (30–60 Days)',                                   'icon' => 'fa-magnifying-glass-chart'],
            ];
        @endphp

        <div class="relative">
            {{-- Vertical spine (desktop only) --}}
            <div class="absolute left-1/2 top-0 bottom-0 w-px -translate-x-1/2
                        bg-gradient-to-b from-transparent via-blue-200 to-transparent
                        hidden sm:block pointer-events-none">
            </div>

            <div class="space-y-4">
                @foreach ($steps as $index => $step)
                    @php $isEven = $index % 2 === 0; @endphp

                    <div class="lp-step flex items-center gap-4 sm:gap-0
                                {{ $isEven ? 'sm:flex-row' : 'sm:flex-row-reverse' }}"
                         style="animation-delay: {{ $index * 0.06 }}s">

                        {{-- Step card --}}
                        <div class="flex-1 sm:px-6 group">
                            <div class="bg-white border border-slate-200 rounded-2xl px-5 py-4
                                        shadow-sm hover:shadow-md hover:border-blue-300 hover:-translate-y-0.5
                                        transition-all duration-300 cursor-default">

                                <div class="flex items-center gap-3
                                            {{ $isEven ? 'sm:flex-row-reverse sm:text-right' : 'sm:text-left' }}
                                            flex-row text-left">

                                    <div class="flex-shrink-0 w-9 h-9 rounded-xl bg-blue-50 border border-blue-100
                                                flex items-center justify-center
                                                group-hover:bg-blue-800 group-hover:border-blue-800
                                                transition-colors duration-300">
                                        <i class="fa-solid {{ $step['icon'] }} text-blue-700 group-hover:text-white text-xs
                                                  transition-colors duration-300"></i>
                                    </div>

                                    <p class="text-blue-900 text-sm font-semibold leading-snug flex-1">
                                        {{ $step['label'] }}
                                    </p>

                                </div>
                            </div>
                        </div>

                        {{-- Centre number badge --}}
                        <div class="flex-shrink-0 z-10
                                    w-11 h-11 sm:w-12 sm:h-12
                                    rounded-full bg-blue-800 border-4 border-slate-50
                                    flex items-center justify-center
                                    shadow-md shadow-blue-800/30
                                    hover:bg-green-700 hover:shadow-green-700/30
                                    transition-all duration-300 cursor-default select-none">
                            <span class="text-white font-bold text-sm" style="font-family: 'Playfair Display', serif;">
                                {{ $index + 1 }}
                            </span>
                        </div>

                        {{-- Mirror spacer (desktop) --}}
                        <div class="flex-1 sm:px-6 hidden sm:block"></div>

                    </div>
                @endforeach
            </div>
        </div>

        {{-- ══ CITIZENS CHARTER ══ --}}
        <div class="mt-20">

            <div class="text-center mb-10">
                <span class="inline-block text-blue-800 text-xs tracking-[0.3em] uppercase font-bold
                             border border-blue-200 bg-blue-50 rounded-full px-4 py-1.5 mb-3">
                    Official Documents
                </span>
                <h2 class="text-blue-900 text-2xl sm:text-3xl font-bold" style="font-family: 'Playfair Display', serif;">
                    Citizens Charter
                </h2>
                <p class="text-slate-400 text-sm mt-2">Published documents from the Sangguniang Bayan</p>
                <div class="w-14 h-0.5 bg-gradient-to-r from-blue-800 to-transparent mx-auto mt-4 rounded-full"></div>
            </div>

            @if ($charters->isNotEmpty())
                @foreach ($charters as $charter)
                    @php
                        $fileUrl = asset('storage/' . $charter->file);
                        $isPdf   = str_ends_with(strtolower($charter->file), '.pdf');
                    @endphp

                    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden mb-6
                                hover:shadow-md hover:border-blue-300 transition-all duration-300">

                        {{-- Card header --}}
                        <div class="flex items-center gap-4 px-6 py-4 bg-blue-900">
                            <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center flex-shrink-0">
                                <i class="fa-solid {{ $isPdf ? 'fa-file-pdf' : 'fa-file-word' }} text-white text-sm"></i>
                            </div>

                            <div class="flex-1 min-w-0">
                                <p class="text-white font-bold text-sm truncate" style="font-family: 'Playfair Display', serif;">
                                    {{ $charter->title }}
                                </p>
                                <p class="text-white/50 text-xs mt-0.5">
                                    {{ $isPdf ? 'PDF Document' : 'Word Document' }}
                                    &nbsp;·&nbsp;
                                    Published {{ $charter->created_at->format('F d, Y') }}
                                </p>
                            </div>

                            {{-- Window chrome --}}
                            <div class="flex items-center gap-1.5 flex-shrink-0">
                                <span class="w-3 h-3 rounded-full bg-red-400/70"></span>
                                <span class="w-3 h-3 rounded-full bg-yellow-400/70"></span>
                                <span class="w-3 h-3 rounded-full bg-green-400/70"></span>
                            </div>
                        </div>

                        {{-- Viewer --}}
                        @if ($isPdf)
                            <div class="w-full bg-slate-100" style="height: 80vh;">
                                <iframe
                                    src="{{ $fileUrl }}#toolbar=0&navpanes=0&scrollbar=1&view=FitH"
                                    class="w-full h-full border-0"
                                    title="{{ $charter->title }}"
                                ></iframe>
                            </div>
                        @else
                            <div class="py-16 text-center px-6">
                                <div class="w-14 h-14 rounded-full bg-slate-100 flex items-center justify-center mx-auto mb-4">
                                    <i class="fa-solid fa-file-word text-blue-300 text-2xl"></i>
                                </div>
                                <p class="text-blue-900 font-semibold text-sm">{{ $charter->title }}</p>
                                <p class="text-slate-400 text-xs mt-1">
                                    Word documents cannot be previewed inline.<br>
                                    Please re-upload as a PDF to enable preview.
                                </p>
                            </div>
                        @endif

                    </div>
                @endforeach

            @else
                <div class="bg-white border border-slate-200 rounded-2xl shadow-sm py-20 text-center">
                    <div class="w-16 h-16 rounded-full bg-slate-100 flex items-center justify-center mx-auto mb-4">
                        <i class="fa-solid fa-folder-open text-slate-300 text-2xl"></i>
                    </div>
                    <p class="text-slate-400 font-semibold text-sm">No Citizens Charter Published</p>
                    <p class="text-slate-300 text-xs mt-1">Check back later for official documents.</p>
                </div>
            @endif

        </div>

    </div>

</div>

<style>
    @keyframes lpFadeUp {
        from { opacity: 0; transform: translateY(20px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .lp-step {
        opacity: 0;
        animation: lpFadeUp .5s ease forwards;
    }
</style>

@endsection
