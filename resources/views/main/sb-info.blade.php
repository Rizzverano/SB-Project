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
                        The Legislative Body<br class="hidden sm:block"> of Hilongos
                    </h2>
                    <div class="flex items-center gap-2 mb-5">
                        <span class="w-10 h-[3px] bg-green-500 block"></span>
                        <span class="w-3 h-[3px] bg-green-300 block"></span>
                    </div>
                    <p class="text-slate-600 text-sm sm:text-base leading-relaxed mb-4">
                        The <strong class="text-blue-950 font-semibold">Sangguniang Bayan</strong> is the legislative
                        body responsible for creating ordinances, resolutions, and policies that support the development
                        and governance of the town.
                    </p>
                    <p class="text-slate-500 text-sm leading-relaxed">
                        Serving the people of <strong class="text-blue-950 font-medium">Hilongos, Leyte</strong> through
                        principled governance, transparent lawmaking, and responsive public service.
                    </p>
                </div>


                {{-- Right: Image --}}
                <div class="flex-1 w-full">
                    <img src="{{ optional($officialsImage)->image ? asset('storage/' . $officialsImage->image) : asset('images/Sb.jpg') }}"
                        class="w-full h-auto object-contain block" alt="SB Members Photo">
                </div>
            </div>
        </div>
    </section>

    {{-- ══════════════════ POWERS & FUNCTIONS ══════════════════ --}}
    <section class="bg-slate-50 py-12 px-4">
        <div class="max-w-5xl mx-auto">

            <div class="mb-8">
                <span class="inline-block text-green-600 text-[11px] tracking-[0.35em] uppercase font-semibold mb-2">
                    Mandate
                </span>
                <h3 class="font-playfair text-blue-950 text-2xl sm:text-3xl font-bold">
                    Powers &amp; Functions
                </h3>
            </div>

            @php
                $powers = [
                    [
                        'icon' =>
                            'M12 3h.393a7.5 7.5 0 0 0 7.92 6.638A8.5 8.5 0 0 1 12 21a8.5 8.5 0 0 1-8.313-11.362 7.5 7.5 0 0 0 7.92-6.638H12z',
                        'label' => 'Legislation',
                        'text' => 'Enact ordinances and approve resolutions for effective municipal governance',
                    ],
                    [
                        'icon' =>
                            'M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2M9 5a2 2 0 0 0 2 2h2a2 2 0 0 0 2-2M9 5a2 2 0 0 0 2-2h2a2 2 0 0 0 2 2',
                        'label' => 'Budgeting',
                        'text' => 'Approve municipal and barangay budgets and development plans',
                    ],
                    [
                        'icon' => 'M3 21h18M5 21V7l8-4 8 4v14M9 21V11h6v10',
                        'label' => 'Regulation',
                        'text' => 'Regulate land use, businesses, and public utilities',
                    ],
                    [
                        'icon' =>
                            'M3.055 11H5a2 2 0 0 1 2 2v1a2 2 0 0 0 2 2 2 2 0 0 1 2 2v2.945M8 3.935V5.5A2.5 2.5 0 0 0 10.5 8h.5a2 2 0 0 1 2 2 2 2 0 0 0 4 0 2 2 0 0 1 2-2h1.064M15 20.488V18a2 2 0 0 1 2-2h3.064',
                        'label' => 'Public Safety',
                        'text' => 'Provide for public safety, environmental protection, and infrastructure development',
                    ],
                ];
            @endphp

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                @foreach ($powers as $power)
                    <div
                        class="bg-white border border-slate-200 p-5 flex flex-col gap-3 hover:border-green-400 hover:shadow-sm transition-all duration-200">
                        <div
                            class="w-10 h-10 bg-green-50 border border-green-200 flex items-center justify-center flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-600" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $power['icon'] }}" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-blue-950 font-semibold text-xs uppercase tracking-wider mb-1">
                                {{ $power['label'] }}</p>
                            <p class="text-slate-600 text-sm leading-relaxed">{{ $power['text'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </section>

    {{-- ══════════════════ MAJOR ACCOMPLISHMENTS ══════════════════ --}}
    <section class="bg-blue-950 py-14 px-4">
        <div class="max-w-5xl mx-auto">

            <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-3 mb-10">
                <div>
                    <span class="inline-block text-green-300 text-[11px] tracking-[0.35em] uppercase font-semibold mb-2">
                        Track Record
                    </span>
                    <h3 class="font-playfair text-white text-2xl sm:text-3xl md:text-4xl font-bold">
                        Major Accomplishments
                    </h3>
                </div>
                <p class="text-white/40 text-xs sm:text-sm sm:text-right max-w-xs">
                    Key ordinances enacted across multiple sectors
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @forelse ($accomplishments as $committeeName => $ordinances)
                    <div class="border border-white/10 bg-white/5 p-5">
                        <h4
                            class="text-green-300 text-[10px] tracking-[0.25em] uppercase font-bold mb-3 pb-2 border-b border-white/10">
                            {{ $committeeName }}
                        </h4>

                        <table class="w-full">
                            <thead>
                                <tr class="text-white/30 text-[10px] uppercase tracking-wider">
                                    <th class="text-left pb-2 pr-4 w-28 font-normal">
                                        Ord. No.
                                    </th>
                                    <th class="text-left pb-2 font-normal">
                                        Title
                                    </th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($ordinances as $ord)
                                    <tr class="border-t border-white/5 group">
                                        <td class="py-2 pr-4 text-green-400 font-mono text-xs align-top whitespace-nowrap">
                                            {{ $ord->ord_no }}
                                        </td>

                                        <td
                                            class="py-2 text-white/65 text-xs leading-snug align-top group-hover:text-white/90 transition-colors">
                                            {{ $ord->ord_title }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @empty
                    <div class="col-span-full text-center text-white/50 py-10">
                        No accomplishments available.
                    </div>
                @endforelse
            </div>

            {{-- Award Banner --}}
            @foreach ($recognitions as $recognition)
                <div
                    class="mt-6 bg-green-500/10 border border-green-400/25 p-5 flex flex-col sm:flex-row items-center gap-4 text-center sm:text-left">

                    <div
                        class="w-12 h-12 flex-shrink-0 bg-green-500/20 border border-green-400/30 flex items-center justify-center text-2xl">
                        🏆
                    </div>

                    <div>
                        <p class="text-green-300 text-[10px] tracking-[0.3em] uppercase font-semibold mb-1">
                            Recognition
                        </p>

                        <p class="text-white font-semibold text-sm sm:text-base leading-snug">
                            {{ $recognition->award }}
                        </p>

                        <p class="text-white/40 text-xs mt-0.5">
                            {{ $recognition->category }}
                        </p>
                    </div>

                </div>
            @endforeach

        </div>
    </section>

    {{-- ══════════════════ MAJOR TARGETS ══════════════════ --}}
    <section class="bg-slate-50 py-14 px-4">
        <div class="max-w-5xl mx-auto">

            <div class="mb-10">
                <span class="inline-block text-green-600 text-[11px] tracking-[0.35em] uppercase font-semibold mb-2">
                    Looking Ahead
                </span>
                <h3 class="font-playfair text-blue-950 text-2xl sm:text-3xl md:text-4xl font-bold">
                    Major Targets in the Next Three Years
                </h3>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @forelse ($targets as $title => $items)
                    <div
                        class="bg-white border border-slate-200 p-5 flex flex-col hover:border-green-400 hover:shadow-sm transition-all duration-200">

                        <div class="flex items-center gap-2 mb-3 pb-2 border-b-2 border-green-500">
                            <h4 class="text-blue-950 text-[10px] tracking-[0.2em] uppercase font-bold">
                                {{ $title }}
                            </h4>

                            <span
                                class="ml-auto text-[10px] font-mono text-green-600 bg-green-50 px-1.5 py-0.5 border border-green-200">
                                {{ $items->count() }}
                            </span>
                        </div>

                        <ul class="space-y-1.5 flex-1">
                            @foreach ($items as $target)
                                <li class="flex items-start gap-2 text-slate-600 text-xs leading-snug">
                                    <span class="text-green-500 flex-shrink-0 mt-0.5 font-bold">
                                        ▸
                                    </span>

                                    <span>
                                        {{ $target->description }}
                                    </span>
                                </li>
                            @endforeach
                        </ul>

                    </div>
                @empty
                    <div class="col-span-full text-center py-10 text-slate-500">
                        No targets available.
                    </div>
                @endforelse
            </div>

        </div>
    </section>

    {{-- ══════════════════ CHALLENGES & SUGGESTED ACTIONS ══════════════════ --}}
    <section class="bg-blue-950 py-14 px-4">
        <div class="max-w-5xl mx-auto">

            <div class="mb-10 text-center">
                <span class="inline-block text-green-300 text-[11px] tracking-[0.35em] uppercase font-semibold mb-2">
                    Governance Outlook
                </span>
                <h3 class="font-playfair text-white text-2xl sm:text-3xl md:text-4xl font-bold">
                    Challenges &amp; Suggested Actions
                </h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- Challenges --}}
                <div class="border border-white/10 bg-white/5 p-6">
                    <div class="flex items-center gap-3 mb-5">
                        <div
                            class="w-8 h-8 bg-red-500/20 border border-red-400/30 flex items-center justify-center flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-red-400" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                            </svg>
                        </div>
                        <h4 class="text-white font-playfair text-lg font-bold">Major Challenges</h4>
                    </div>
                    <div class="space-y-4">
                        @foreach ($outlooks['Challenges'] ?? [] as $challenge)
                            <div class="border-l-2 border-red-400/60 pl-4">
                                @if ($challenge->title)
                                    <p class="text-white text-sm font-semibold mb-1">
                                        {{ $challenge->title }}
                                    </p>
                                @endif

                                <p class="text-white/50 text-xs leading-relaxed">
                                    {{ $challenge->description }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Suggested Actions --}}
                <div class="border border-white/10 bg-white/5 p-6">
                    <div class="flex items-center gap-3 mb-5">
                        <div
                            class="w-8 h-8 bg-green-500/20 border border-green-400/30 flex items-center justify-center flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-green-400" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h4 class="text-white font-playfair text-lg font-bold">Suggested Actions</h4>
                    </div>
                    <ul class="space-y-3">
                        @foreach ($outlooks['Suggestions'] ?? [] as $index => $suggestion)
                            <li class="flex items-start gap-3">
                                <span
                                    class="flex-shrink-0 w-5 h-5 bg-green-500/20 border border-green-400/40 text-green-300 text-[10px] font-bold flex items-center justify-center mt-0.5">
                                    {{ $index + 1 }}
                                </span>

                                <div>
                                    @if ($suggestion->title)
                                        <p class="text-white text-sm font-medium">
                                            {{ $suggestion->title }}
                                        </p>
                                    @endif

                                    <span class="text-white/70 text-sm leading-snug">
                                        {{ $suggestion->description }}
                                    </span>
                                </div>
                            </li>
                        @endforeach
                    </ul>

                </div>
            </div>
    </section>

@endsection
