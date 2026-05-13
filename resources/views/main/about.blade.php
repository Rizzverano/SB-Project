@extends('layout.layout')

@section('content')

{{-- ══════════════════════════════════════════
     HERO
══════════════════════════════════════════ --}}
<div class="relative bg-gradient-to-br from-blue-950 via-blue-900 to-slate-900 py-24 px-4 overflow-hidden">
    <div class="absolute top-0 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[700px] h-[700px] rounded-full border border-white/5 pointer-events-none"></div>
    <div class="absolute top-0 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[450px] h-[450px] rounded-full border border-white/5 pointer-events-none"></div>
    <div class="absolute -bottom-24 -right-24 w-72 h-72 rounded-full bg-green-500/10 blur-3xl pointer-events-none"></div>
    <div class="absolute -top-12 -left-12 w-56 h-56 rounded-full bg-blue-400/10 blur-2xl pointer-events-none"></div>

    <div class="relative z-10 text-center max-w-2xl mx-auto">
        <span class="inline-block text-green-400 text-xs tracking-[0.4em] uppercase font-semibold mb-4">
            Hilongos, Leyte • LGU
        </span>
        <h1 class="text-white text-4xl sm:text-5xl font-bold leading-tight mb-4" style="font-family: 'Playfair Display', serif;">
            About the Office
        </h1>
        <p class="text-white/50 text-sm leading-relaxed max-w-md mx-auto">
            Learn about the vision, mission, organizational structure, and location of the Sangguniang Bayan of Hilongos, Leyte.
        </p>

    </div>
</div>

{{-- ══════════════════════════════════════════
     VISION & MISSION
══════════════════════════════════════════ --}}
<section id="vision" class="bg-slate-50 py-20 px-4 scroll-mt-4">
    <div class="max-w-6xl mx-auto">

        {{-- Section heading --}}
        <div class="text-center mb-14">
            <span class="inline-block text-blue-800 text-xs tracking-[0.3em] uppercase font-bold
                         border border-blue-200 bg-blue-50 rounded-full px-4 py-1.5 mb-3">
                Office Mandate
            </span>
            <h2 class="text-3xl sm:text-4xl font-bold text-blue-900" style="font-family: 'Playfair Display', serif;">
                Vision &amp; Mission
            </h2>
            <p class="text-slate-400 text-sm mt-2">Guiding principles of the Sangguniang Bayan of Hilongos, Leyte</p>
            <div class="w-14 h-0.5 bg-gradient-to-r from-blue-800 to-transparent mx-auto mt-4 rounded-full"></div>
        </div>

        <div class="space-y-10">

            {{-- ── CARD 1: Vice Mayor ── --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden hover:shadow-md hover:border-blue-300 transition-all duration-300">

                {{-- Card header --}}
                <div class="bg-blue-900 px-6 py-5 flex items-center gap-4">
                    <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center flex-shrink-0">
                        <i class="fa-solid fa-user-tie text-white text-sm"></i>
                    </div>
                    <div>
                        <p class="text-green-300 text-[10px] tracking-[3px] uppercase font-semibold">Office of the</p>
                        <h3 class="text-white font-bold text-lg leading-tight" style="font-family: 'Playfair Display', serif;">
                            Vice Mayor
                        </h3>
                    </div>
                </div>

                {{-- Gradient divider --}}
                <div class="h-[3px] bg-gradient-to-r from-blue-900 via-green-400 to-blue-900"></div>

                <div class="grid md:grid-cols-2 divide-y md:divide-y-0 md:divide-x divide-slate-100">

                    {{-- Vision --}}
                    <div class="p-6 sm:p-8">
                        <div class="flex items-center gap-2 mb-4">
                            <div class="w-8 h-8 rounded-lg bg-blue-50 border border-blue-200 flex items-center justify-center flex-shrink-0">
                                <i class="fa-solid fa-eye text-blue-700 text-xs"></i>
                            </div>
                            <span class="text-blue-800 text-xs font-bold uppercase tracking-[0.25em]">Vision</span>
                        </div>
                        <div class="pl-4 border-l-4 border-green-400">
                            <p class="text-slate-600 text-sm leading-8">
                                A dynamic, principled and visionary legislative leader committed to fostering inclusive
                                development, accountable governance and responsive legislation that supports Hilongos as
                                the agro-industrialized food capital and gateway of Eastern Visayas.
                            </p>
                        </div>
                    </div>

                    {{-- Mission --}}
                    <div class="p-6 sm:p-8">
                        <div class="flex items-center gap-2 mb-4">
                            <div class="w-8 h-8 rounded-lg bg-green-50 border border-green-200 flex items-center justify-center flex-shrink-0">
                                <i class="fa-solid fa-bullseye text-green-700 text-xs"></i>
                            </div>
                            <span class="text-green-700 text-xs font-bold uppercase tracking-[0.25em]">Mission</span>
                        </div>
                        <div class="pl-4 border-l-4 border-blue-800">
                            <p class="text-slate-600 text-sm leading-8">
                                To lead the Sangguniang Bayan in enacting quality, pro-people and development-oriented
                                legislation; uphold participatory and transparent governance; and empower communities
                                through policies that promote agriculture, industry, disaster resilience and social equity.
                            </p>
                        </div>
                    </div>

                </div>
            </div>

            {{-- ── CARD 2: Sangguniang Bayan ── --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden hover:shadow-md hover:border-green-300 transition-all duration-300">

                <div class="bg-blue-900 px-6 py-5 flex items-center gap-4">
                    <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center flex-shrink-0">
                        <i class="fa-solid fa-landmark text-white text-sm"></i>
                    </div>
                    <div>
                        <p class="text-green-300 text-[10px] tracking-[3px] uppercase font-semibold">Legislative Body</p>
                        <h3 class="text-white font-bold text-lg leading-tight" style="font-family: 'Playfair Display', serif;">
                            Sangguniang Bayan
                        </h3>
                    </div>
                </div>

                <div class="h-[3px] bg-gradient-to-r from-blue-900 via-green-400 to-blue-900"></div>

                <div class="grid md:grid-cols-2 divide-y md:divide-y-0 md:divide-x divide-slate-100">

                    {{-- Vision --}}
                    <div class="p-6 sm:p-8">
                        <div class="flex items-center gap-2 mb-4">
                            <div class="w-8 h-8 rounded-lg bg-blue-50 border border-blue-200 flex items-center justify-center flex-shrink-0">
                                <i class="fa-solid fa-eye text-blue-700 text-xs"></i>
                            </div>
                            <span class="text-blue-800 text-xs font-bold uppercase tracking-[0.25em]">Vision</span>
                        </div>
                        <div class="pl-4 border-l-4 border-green-400">
                            <p class="text-slate-600 text-sm leading-8">
                                A pro-active and principled legislative body that enacts responsive, inclusive and
                                development-driven policies to support Hilongos as the premier gateway and agro-industrial
                                food production capital of Eastern Visayas — anchored on resilience, integrity and
                                empowerment of its people.
                            </p>
                        </div>
                    </div>

                    {{-- Mission --}}
                    <div class="p-6 sm:p-8">
                        <div class="flex items-center gap-2 mb-4">
                            <div class="w-8 h-8 rounded-lg bg-green-50 border border-green-200 flex items-center justify-center flex-shrink-0">
                                <i class="fa-solid fa-bullseye text-green-700 text-xs"></i>
                            </div>
                            <span class="text-green-700 text-xs font-bold uppercase tracking-[0.25em]">Mission</span>
                        </div>
                        <div class="pl-4 border-l-4 border-blue-800">
                            <p class="text-slate-600 text-sm leading-8">
                                To craft and enact quality local legislation that upholds transparency, accountability
                                and participatory governance and to protect the welfare, values and aspirations of every
                                Hilongosnon through competent and God-centered public service.
                            </p>
                        </div>
                    </div>

                </div>
            </div>

            {{-- ── CARD 3: Office of the Secretary ── --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden hover:shadow-md hover:border-blue-300 transition-all duration-300">

                <div class="bg-blue-900 px-6 py-5 flex items-center gap-4">
                    <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center flex-shrink-0">
                        <i class="fa-solid fa-file-pen text-white text-sm"></i>
                    </div>
                    <div>
                        <p class="text-green-300 text-[10px] tracking-[3px] uppercase font-semibold">Support Office</p>
                        <h3 class="text-white font-bold text-lg leading-tight" style="font-family: 'Playfair Display', serif;">
                            Office of the Secretary to the Sangguniang Bayan
                        </h3>
                    </div>
                </div>

                <div class="h-[3px] bg-gradient-to-r from-blue-900 via-green-400 to-blue-900"></div>

                <div class="grid md:grid-cols-2 divide-y md:divide-y-0 md:divide-x divide-slate-100">

                    {{-- Vision --}}
                    <div class="p-6 sm:p-8">
                        <div class="flex items-center gap-2 mb-4">
                            <div class="w-8 h-8 rounded-lg bg-blue-50 border border-blue-200 flex items-center justify-center flex-shrink-0">
                                <i class="fa-solid fa-eye text-blue-700 text-xs"></i>
                            </div>
                            <span class="text-blue-800 text-xs font-bold uppercase tracking-[0.25em]">Vision</span>
                        </div>
                        <div class="pl-4 border-l-4 border-green-400">
                            <p class="text-slate-600 text-sm leading-8">
                                A highly efficient and professional legislative support office that upholds transparency,
                                accuracy and integrity — empowering responsive governance towards a progressive,
                                disaster-resilient and God-centered Hilongos.
                            </p>
                        </div>
                    </div>

                    {{-- Mission --}}
                    <div class="p-6 sm:p-8">
                        <div class="flex items-center gap-2 mb-4">
                            <div class="w-8 h-8 rounded-lg bg-green-50 border border-green-200 flex items-center justify-center flex-shrink-0">
                                <i class="fa-solid fa-bullseye text-green-700 text-xs"></i>
                            </div>
                            <span class="text-green-700 text-xs font-bold uppercase tracking-[0.25em]">Mission</span>
                        </div>
                        <div class="pl-4 border-l-4 border-blue-800">
                            <p class="text-slate-600 text-sm leading-8">
                                To provide timely, accurate and transparent legislative documentation and administrative
                                support to the Sangguniang Bayan through efficient secretariat services and accessible
                                legislative records that promote responsive, lawful and inclusive policy-making.
                            </p>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════
     ORGANIZATIONAL CHART
══════════════════════════════════════════ --}}
<section id="org-chart" class="bg-slate-50 py-20 px-4 scroll-mt-4">
    <div class="max-w-6xl mx-auto">

        {{-- Section heading --}}
        <div class="text-center mb-12">
            <span class="inline-block text-blue-800 text-xs tracking-[0.3em] uppercase font-bold
                         border border-blue-200 bg-blue-50 rounded-full px-4 py-1.5 mb-3">
                Office Structure
            </span>
            <h2 class="text-3xl sm:text-4xl font-bold text-blue-900" style="font-family: 'Playfair Display', serif;">
                Organizational Chart
            </h2>
            <p class="text-slate-400 text-sm mt-2">Published structure of the Sangguniang Bayan</p>
            <div class="w-14 h-0.5 bg-gradient-to-r from-blue-800 to-transparent mx-auto mt-4 rounded-full"></div>
        </div>

        @if ($orgCharts->isNotEmpty())
            <div class="space-y-6">
                @foreach ($orgCharts as $chart)
                    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden
                                hover:shadow-md hover:border-blue-300 transition-all duration-300">

                        {{-- Card header --}}
                        <div class="flex items-center gap-4 px-6 py-4 bg-blue-900">
                            <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center flex-shrink-0">
                                <i class="fa-solid fa-sitemap text-white text-sm"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-white font-bold text-sm truncate" style="font-family: 'Playfair Display', serif;">
                                    {{ $chart->title }}
                                </p>
                                <p class="text-white/50 text-xs mt-0.5">
                                    Published {{ $chart->created_at->format('F d, Y') }}
                                </p>
                            </div>
                            {{-- Window chrome --}}
                            <div class="flex items-center gap-1.5 flex-shrink-0">
                                <span class="w-3 h-3 rounded-full bg-red-400/70"></span>
                                <span class="w-3 h-3 rounded-full bg-yellow-400/70"></span>
                                <span class="w-3 h-3 rounded-full bg-green-400/70"></span>
                            </div>
                        </div>

                        {{-- Chart image --}}
                        @if ($chart->file)
                            <div class="p-4 sm:p-6 bg-slate-50">
                                <img src="{{ asset('storage/' . $chart->file) }}"
                                     alt="{{ $chart->title }}"
                                     class="w-full rounded-xl border border-slate-200 shadow-sm object-contain max-h-[70vh]
                                            cursor-zoom-in transition-transform duration-300 hover:scale-[1.01]"
                                     onclick="openLightbox(this.src, '{{ addslashes($chart->title) }}')">
                                <p class="text-center text-slate-400 text-xs mt-3">
                                    <i class="fa-solid fa-magnifying-glass-plus mr-1"></i>
                                    Click image to enlarge
                                </p>
                            </div>
                        @else
                            <div class="py-16 text-center px-6">
                                <div class="w-14 h-14 rounded-full bg-slate-100 flex items-center justify-center mx-auto mb-4">
                                    <i class="fa-solid fa-image text-slate-300 text-2xl"></i>
                                </div>
                                <p class="text-slate-400 text-sm font-semibold">No image available</p>
                                <p class="text-slate-300 text-xs mt-1">The chart image has not been uploaded yet.</p>
                            </div>
                        @endif

                    </div>
                @endforeach
            </div>

        @else
            <div class="bg-white border border-slate-200 rounded-2xl py-20 text-center shadow-sm">
                <div class="w-16 h-16 rounded-full bg-slate-100 flex items-center justify-center mx-auto mb-4">
                    <i class="fa-solid fa-sitemap text-slate-300 text-2xl"></i>
                </div>
                <p class="text-slate-400 font-semibold text-sm">No Organizational Chart Published</p>
                <p class="text-slate-300 text-xs mt-1">Check back later for updates.</p>
            </div>
        @endif

    </div>
</section>

{{-- ══════════════════════════════════════════
     MAP / LOCATION
══════════════════════════════════════════ --}}
<section id="location" class="bg-blue-950 py-20 px-4 scroll-mt-4">
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

        {{-- Info strip --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
            @foreach ([
                ['fa-location-dot', 'Address',      'Western Barangay,<br>Hilongos, Leyte'],
                ['fa-clock',        'Office Hours', 'Monday – Friday<br>8:00 AM – 5:00 PM'],
                ['fa-phone',        'Contact',      '(+63) 954 305 6206'],
            ] as $info)
                <div class="bg-white/5 border border-white/10 rounded-2xl p-5 text-center
                            hover:bg-white/10 transition-colors duration-300">
                    <i class="fa-solid {{ $info[0] }} text-green-400 text-xl mb-3 block"></i>
                    <p class="text-white text-xs font-bold uppercase tracking-wide mb-1">{{ $info[1] }}</p>
                    <p class="text-white/50 text-xs leading-relaxed">{!! $info[2] !!}</p>
                </div>
            @endforeach
        </div>

        {{-- Map embed --}}
        <div class="rounded-2xl overflow-hidden shadow-2xl border-2 border-white/10">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3922.314987654321!2d124.7447686!3d10.3717315!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33076f38c5ea9443%3A0xc1f118b5152ba196!2sLegislative%20Building!5e0!3m2!1sen!2sph!4v1714440000000!5m2!1sen!2sph"
                class="w-full block"
                style="height: clamp(260px, 40vw, 480px); border: 0;"
                allowfullscreen=""
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>

    </div>
</section>

{{-- ══════════════════════════════════════════
     LIGHTBOX
══════════════════════════════════════════ --}}
<div id="lightbox"
     class="fixed inset-0 z-50 hidden items-center justify-center bg-black/80 backdrop-blur-sm p-4"
     onclick="closeLightbox()">

    <div class="relative max-w-6xl w-full" onclick="event.stopPropagation()">
        {{-- Close button --}}
        <button onclick="closeLightbox()"
                class="absolute -top-12 right-0 w-9 h-9 rounded-full bg-white/10 hover:bg-white/20
                       flex items-center justify-center text-white transition-colors">
            <i class="fa-solid fa-xmark text-sm"></i>
        </button>

        {{-- Image --}}
        <img id="lightbox-img" src="" alt=""
             class="w-full max-h-[85vh] object-contain rounded-2xl shadow-2xl border border-white/10">

        {{-- Caption --}}
        <p id="lightbox-caption"
           class="text-center text-white/60 text-xs mt-3 font-semibold uppercase tracking-widest"></p>
    </div>
</div>

<script>
    function openLightbox(src, title) {
        document.getElementById('lightbox-img').src = src;
        document.getElementById('lightbox-caption').textContent = title;
        const lb = document.getElementById('lightbox');
        lb.classList.remove('hidden');
        lb.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }

    function closeLightbox() {
        const lb = document.getElementById('lightbox');
        lb.classList.add('hidden');
        lb.classList.remove('flex');
        document.body.style.overflow = '';
    }

    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') closeLightbox();
    });
</script>

@endsection
