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

        {{-- Anchor nav --}}
        <div class="flex flex-wrap justify-center gap-3 mt-8">
            @foreach ([['#vision','fa-eye','Vision'], ['#mission','fa-bullseye','Mission'], ['#org-chart','fa-sitemap','Org Chart'], ['#location','fa-location-dot','Location']] as $nav)
                <a href="{{ $nav[0] }}"
                   class="inline-flex items-center gap-2 bg-white/10 hover:bg-white/20 border border-white/15
                          text-white text-xs font-semibold uppercase tracking-widest px-4 py-2 rounded-full
                          transition-all duration-200 hover:-translate-y-0.5">
                    <i class="fa-solid {{ $nav[1] }} text-green-400 text-[10px]"></i>
                    {{ $nav[2] }}
                </a>
            @endforeach
        </div>
    </div>
</div>

{{-- ══════════════════════════════════════════
     VISION
══════════════════════════════════════════ --}}
<section id="vision" class="bg-slate-50 py-20 px-4 overflow-hidden scroll-mt-4">
    <div class="max-w-6xl mx-auto">

        <div class="grid md:grid-cols-2 gap-10 lg:gap-16 items-center">

            {{-- Image --}}
            <div class="relative group">
                <div class="absolute -inset-2 bg-gradient-to-br from-blue-800 to-blue-600 rounded-2xl opacity-20 blur-xl group-hover:opacity-30 transition-opacity duration-500"></div>
                <div class="relative rounded-2xl overflow-hidden shadow-xl border-4 border-white">
                    <img src="{{ asset('images/legis-building.jpg') }}"
                         alt="Legislative Building"
                         class="w-full h-64 sm:h-80 md:h-96 object-cover group-hover:scale-105 transition-transform duration-700">
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
                    Guided by a Clear<br class="hidden sm:block"> Vision
                </h2>
                <div class="relative pl-5 border-l-4 border-green-400 mb-8">
                    <p class="text-slate-600 leading-8 text-sm sm:text-base">
                        A transparent, accountable, and people-centered legislative office committed to crafting responsive
                        and progressive laws that promote sustainable development, social justice, and improved quality of life
                        for every citizen of Hilongos.
                    </p>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    @foreach ([
                        ['fa-eye',          'Transparency', 'Open governance for all'],
                        ['fa-scale-balanced','Accountability','Responsible legislation'],
                        ['fa-seedling',     'Sustainability','Long-term community growth'],
                        ['fa-people-group', 'People-Centered','Citizens first approach'],
                    ] as $card)
                        <div class="bg-white rounded-xl p-4 border border-slate-200 shadow-sm
                                    hover:border-blue-300 hover:shadow-md hover:-translate-y-0.5
                                    transition-all duration-300">
                            <i class="fa-solid {{ $card[0] }} text-blue-700 mb-2 text-lg block"></i>
                            <p class="text-xs font-bold text-blue-900 uppercase tracking-wide">{{ $card[1] }}</p>
                            <p class="text-xs text-slate-400 mt-0.5">{{ $card[2] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</section>

{{-- Divider --}}
<div class="h-px bg-gradient-to-r from-transparent via-slate-300 to-transparent"></div>

{{-- ══════════════════════════════════════════
     MISSION
══════════════════════════════════════════ --}}
<section id="mission" class="bg-slate-50 py-20 px-4 overflow-hidden scroll-mt-4">
    <div class="max-w-6xl mx-auto">

        <div class="grid md:grid-cols-2 gap-10 lg:gap-16 items-center">

            {{-- Text (LEFT desktop, BOTTOM mobile) --}}
            <div class="order-2 md:order-1">
                <span class="inline-flex items-center gap-2 text-green-600 text-xs font-bold uppercase tracking-[0.3em] mb-4">
                    <span class="w-8 h-px bg-green-600"></span>
                    Our Mission
                </span>
                <h2 class="text-3xl sm:text-4xl font-bold text-blue-900 mb-6 leading-tight" style="font-family: 'Playfair Display', serif;">
                    Driven by a<br class="hidden sm:block"> Strong Mission
                </h2>
                <div class="relative pl-5 border-l-4 border-blue-800 mb-8">
                    <p class="text-slate-600 leading-8 text-sm sm:text-base">
                        To efficiently enact ordinances and resolutions that address community needs, uphold democratic principles,
                        and strengthen collaboration between government and citizens for a progressive Hilongos.
                    </p>
                </div>

                <div class="space-y-3">
                    @foreach ([
                        ['fa-gavel',    'Enact Sound Laws',    'Craft ordinances that reflect community needs'],
                        ['fa-handshake','Foster Collaboration','Bridge government and citizen participation'],
                        ['fa-landmark', 'Uphold Democracy',    'Protect democratic principles in governance'],
                    ] as $pillar)
                        <div class="flex items-center gap-4 bg-white rounded-xl p-4 border border-slate-200 shadow-sm
                                    hover:border-green-400 hover:shadow-md transition-all duration-300">
                            <div class="w-10 h-10 rounded-full bg-green-50 border border-green-200 flex items-center justify-center flex-shrink-0">
                                <i class="fa-solid {{ $pillar[0] }} text-green-700 text-sm"></i>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-blue-900 uppercase tracking-wide">{{ $pillar[1] }}</p>
                                <p class="text-xs text-slate-400 mt-0.5">{{ $pillar[2] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Image (RIGHT desktop, TOP mobile) --}}
            <div class="relative group order-1 md:order-2">
                <div class="absolute -inset-2 bg-gradient-to-br from-green-700 to-green-500 rounded-2xl opacity-20 blur-xl group-hover:opacity-30 transition-opacity duration-500"></div>
                <div class="relative rounded-2xl overflow-hidden shadow-xl border-4 border-white">
                    <img src="{{ asset('images/legis-building.jpg') }}"
                         alt="Sangguniang Bayan"
                         class="w-full h-64 sm:h-80 md:h-96 object-cover group-hover:scale-105 transition-transform duration-700">
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

{{-- Divider --}}
<div class="h-px bg-gradient-to-r from-transparent via-slate-300 to-transparent"></div>

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
