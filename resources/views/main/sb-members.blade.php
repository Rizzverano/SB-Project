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
                SB Members
            </h1>
            <p class="text-white/50 text-sm leading-relaxed max-w-md mx-auto">
                Meet the elected officials who represent the people of Hilongos in the Sangguniang Bayan.
            </p>
        </div>
    </div>

    {{-- ══════════════════ TABS ══════════════════ --}}
    <div class="bg-slate-50 border-b border-slate-200 sticky top-0 z-20">
        <div class="max-w-6xl mx-auto px-4 flex justify-center gap-0">

            <button id="tab-current"
                class="relative px-8 py-4 text-xs font-bold uppercase tracking-widest transition-all duration-300
                       text-blue-900 border-b-2 border-blue-800">
                <span class="flex items-center gap-2">
                    <i class="fa-solid fa-users text-sm"></i>
                    Current Members
                </span>
            </button>

            <button id="tab-former"
                class="relative px-8 py-4 text-xs font-bold uppercase tracking-widest transition-all duration-300
                       text-slate-400 border-b-2 border-transparent hover:text-slate-600">
                <span class="flex items-center gap-2">
                    <i class="fa-solid fa-clock-rotate-left text-sm"></i>
                    Former Members
                </span>
            </button>

        </div>
    </div>

    {{-- ══════════════════ CURRENT MEMBERS PANEL ══════════════════ --}}
    <div id="panel-current" class="py-16 px-4 bg-slate-50 min-h-[500px]">

        <div class="max-w-6xl mx-auto mb-10 text-center">
            <div class="inline-flex items-center gap-3">
                <div class="h-px w-12 bg-blue-800/30"></div>
                <span class="text-blue-800 text-xs font-bold uppercase tracking-[0.3em]">Current Term</span>
                <div class="h-px w-12 bg-blue-800/30"></div>
            </div>
        </div>

        <div class="relative max-w-5xl mx-auto">
            <div class="overflow-hidden rounded-2xl">
                <div id="members-slides" class="flex transition-transform duration-700 ease-in-out">
                    @forelse ($members as $member)
                        <div class="w-full sm:w-1/2 md:w-1/3 flex-shrink-0 px-3">
                            <div class="bg-white rounded-2xl overflow-hidden shadow-md hover:shadow-xl transition-shadow duration-300 group">

                                {{-- Image --}}
                                <div class="relative w-full aspect-[3/4] overflow-hidden">
                                    <img src="{{ $member->image ? asset('storage/' . $member->image) : asset('images/default.jpg') }}"
                                        class="w-full h-full object-cover object-top group-hover:scale-105 transition-transform duration-500">
                                    <div class="absolute inset-0 bg-gradient-to-t from-blue-950/80 via-transparent to-transparent"></div>
                                    <div class="absolute bottom-0 left-0 right-0 p-4">
                                        <h3 class="text-white font-bold text-sm leading-tight">{{ $member->name }}</h3>
                                    </div>
                                </div>

                                {{-- Description --}}
                                <div class="p-4 border-t-2 border-green-400">
                                    <p class="text-slate-500 text-xs leading-relaxed">{{ $member->description }}</p>
                                </div>

                            </div>
                        </div>
                    @empty
                        <div class="w-full py-20 text-center">
                            <i class="fa-solid fa-users text-4xl text-slate-300 mb-4 block"></i>
                            <p class="text-slate-400 text-sm">No SB Members found.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Nav Buttons --}}
            <button id="membersPrev"
                class="absolute -left-5 top-1/2 -translate-y-1/2 w-11 h-11 bg-white border border-slate-200 text-blue-800 rounded-full shadow-lg hover:bg-blue-800 hover:text-white hover:border-blue-800 transition-all duration-200 flex items-center justify-center">
                <i class="fa-solid fa-chevron-left text-sm"></i>
            </button>
            <button id="membersNext"
                class="absolute -right-5 top-1/2 -translate-y-1/2 w-11 h-11 bg-white border border-slate-200 text-blue-800 rounded-full shadow-lg hover:bg-blue-800 hover:text-white hover:border-blue-800 transition-all duration-200 flex items-center justify-center">
                <i class="fa-solid fa-chevron-right text-sm"></i>
            </button>

            <div id="membersIndicators" class="flex justify-center mt-8 space-x-2"></div>
        </div>
    </div>

    {{-- ══════════════════ FORMER MEMBERS PANEL ══════════════════ --}}
    <div id="panel-former" class="hidden py-16 px-4 bg-slate-50 min-h-[500px]">

        <div class="max-w-6xl mx-auto mb-10 text-center">
            <div class="inline-flex items-center gap-3">
                <div class="h-px w-12 bg-slate-400/40"></div>
                <span class="text-slate-500 text-xs font-bold uppercase tracking-[0.3em]">Former Members</span>
                <div class="h-px w-12 bg-slate-400/40"></div>
            </div>
        </div>

        <div class="relative max-w-5xl mx-auto">
            <div class="overflow-hidden rounded-2xl">
                <div id="former-slides" class="flex transition-transform duration-700 ease-in-out">
                    @forelse ($formerMembers as $member)
                        <div class="w-full sm:w-1/2 md:w-1/3 flex-shrink-0 px-3">
                            <div class="bg-white rounded-2xl overflow-hidden shadow-md hover:shadow-xl transition-shadow duration-300 group">

                                {{-- Image with grayscale effect for former members --}}
                                <div class="relative w-full aspect-[3/4] overflow-hidden">
                                    <img src="{{ $member->image ? asset('storage/' . $member->image) : asset('images/default.jpg') }}"
                                        class="w-full h-full object-cover object-top group-hover:scale-105 transition-transform duration-500">
                                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 via-transparent to-transparent"></div>
                                    <div class="absolute bottom-0 left-0 right-0 p-4">
                                        <h3 class="text-white font-bold text-sm leading-tight">{{ $member->name }}</h3>
                                    </div>
                                </div>

                                {{-- Description --}}
                                <div class="p-4 border-t-2 border-slate-300">
                                    <p class="text-slate-500 text-xs leading-relaxed">{{ $member->description }}</p>
                                </div>

                            </div>
                        </div>
                    @empty
                        <div class="w-full py-20 text-center">
                            <i class="fa-solid fa-clock-rotate-left text-4xl text-slate-300 mb-4 block"></i>
                            <p class="text-slate-400 text-sm">No Former SB Members found.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Nav Buttons --}}
            <button id="formerPrev"
                class="absolute -left-5 top-1/2 -translate-y-1/2 w-11 h-11 bg-white border border-slate-200 text-slate-600 rounded-full shadow-lg hover:bg-slate-700 hover:text-white hover:border-slate-700 transition-all duration-200 flex items-center justify-center">
                <i class="fa-solid fa-chevron-left text-sm"></i>
            </button>
            <button id="formerNext"
                class="absolute -right-5 top-1/2 -translate-y-1/2 w-11 h-11 bg-white border border-slate-200 text-slate-600 rounded-full shadow-lg hover:bg-slate-700 hover:text-white hover:border-slate-700 transition-all duration-200 flex items-center justify-center">
                <i class="fa-solid fa-chevron-right text-sm"></i>
            </button>

            <div id="formerIndicators" class="flex justify-center mt-8 space-x-2"></div>
        </div>
    </div>

@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", () => {

        function initSlider(containerId, prevId, nextId, indicatorId) {
            const container = document.getElementById(containerId);
            if (!container) return;

            const cards = container.children;
            const prev = document.getElementById(prevId);
            const next = document.getElementById(nextId);
            const indicators = document.getElementById(indicatorId);

            let index = 0;
            const total = cards.length;

            function getWidth() {
                return cards[0]?.offsetWidth || 0;
            }

            function update() {
                container.style.transform = `translateX(-${index * getWidth()}px)`;
                updateDots();
            }

            function createDots() {
                if (!indicators) return;
                indicators.innerHTML = "";
                for (let i = 0; i < total; i++) {
                    const dot = document.createElement("button");
                    dot.className = "w-2.5 h-2.5 rounded-full bg-slate-300 transition-all duration-300";
                    dot.onclick = () => { index = i; update(); };
                    indicators.appendChild(dot);
                }
            }

            function updateDots() {
                if (!indicators) return;
                [...indicators.children].forEach((dot, i) => {
                    dot.className = "w-2.5 h-2.5 rounded-full transition-all duration-300 " +
                        (i === index ? "bg-blue-800 w-6" : "bg-slate-300");
                });
            }

            next?.addEventListener("click", () => { index = (index + 1) % total; update(); });
            prev?.addEventListener("click", () => { index = (index - 1 + total) % total; update(); });

            createDots();
            update();
            window.addEventListener("resize", update);
        }

        initSlider("members-slides", "membersPrev", "membersNext", "membersIndicators");
        initSlider("former-slides", "formerPrev", "formerNext", "formerIndicators");

        // Tabs
        const tabCurrent = document.getElementById("tab-current");
        const tabFormer = document.getElementById("tab-former");
        const panelCurrent = document.getElementById("panel-current");
        const panelFormer = document.getElementById("panel-former");

        tabCurrent.addEventListener("click", () => {
            panelCurrent.classList.remove("hidden");
            panelFormer.classList.add("hidden");
            tabCurrent.className = "relative px-8 py-4 text-xs font-bold uppercase tracking-widest transition-all duration-300 text-blue-900 border-b-2 border-blue-800";
            tabFormer.className = "relative px-8 py-4 text-xs font-bold uppercase tracking-widest transition-all duration-300 text-slate-400 border-b-2 border-transparent hover:text-slate-600";
        });

        tabFormer.addEventListener("click", () => {
            panelFormer.classList.remove("hidden");
            panelCurrent.classList.add("hidden");
            tabFormer.className = "relative px-8 py-4 text-xs font-bold uppercase tracking-widest transition-all duration-300 text-blue-900 border-b-2 border-blue-800";
            tabCurrent.className = "relative px-8 py-4 text-xs font-bold uppercase tracking-widest transition-all duration-300 text-slate-400 border-b-2 border-transparent hover:text-slate-600";
        });

    });
</script>
@endpush
