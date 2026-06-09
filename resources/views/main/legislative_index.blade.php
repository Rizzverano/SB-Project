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
            Transparency Records
        </h1>
        <p class="text-white/50 text-sm leading-relaxed max-w-md mx-auto">
            Browse ordinances and old ordinances @auth and official session records and along with old session records @endauth of the Sangguniang Bayan.
        </p>
    </div>
</div>

{{-- ══════════════════ MAIN CONTENT ══════════════════ --}}
<div class="bg-slate-50 py-14 px-4 sm:px-6 lg:px-8 min-h-screen">
    <div class="max-w-7xl mx-auto">

        {{-- ══ SEARCH BAR ══ --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-5 mb-6">
            <form method="GET" action="{{ route('legislative_index') }}">
                @csrf
                <input type="hidden" name="tab" id="activeTab" value="{{ $activeTab }}">

                <div class="flex flex-wrap gap-3 items-end">

                    <div class="flex-1 min-w-[180px]">
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-wide mb-1.5">
                            @auth Search Session / @endauth Title
                        </label>
                        <input type="text" name="session" value="{{ request('session') }}"
                            placeholder="e.g. @auth First Regular Session / @endauth TASK FORCE - ORD NO. 11"
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-slate-700 text-sm
                                   focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent
                                   placeholder:text-slate-300 transition">
                    </div>

                    <div class="min-w-[160px]">
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-wide mb-1.5">
                            @auth Filter by Date @endauth
                            @guest Filter by Date Published @endguest
                        </label>
                        <input type="date" name="date" value="{{ request('date') }}"
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-slate-700 text-sm
                                   focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                    </div>

                    <div class="flex gap-2">
                        <button type="submit"
                            class="flex items-center gap-2 bg-blue-800 hover:bg-blue-700 text-white text-xs font-bold
                                   uppercase tracking-widest px-5 py-2.5 rounded-xl transition-all duration-200
                                   hover:-translate-y-0.5 shadow-sm shadow-blue-800/30">
                            <i class="fa-solid fa-magnifying-glass text-xs"></i>
                            Search
                        </button>
                        <a href="{{ route('legislative_index') }}"
                            class="flex items-center gap-2 bg-white border border-slate-200 hover:border-blue-300 text-slate-500
                                   hover:text-blue-700 text-xs font-bold uppercase tracking-widest px-5 py-2.5 rounded-xl
                                   transition-all duration-200">
                            <i class="fa-solid fa-rotate-left text-xs"></i>
                            Reset
                        </a>
                    </div>

                </div>
            </form>
        </div>

        {{-- ══ TABS ══ --}}
        <div class="flex justify-center mb-8">
            <div class="inline-flex bg-white border border-slate-200 rounded-2xl p-1.5 shadow-sm gap-1 relative">

                <button type="button" class="tab-btn relative z-10 flex items-center gap-2 px-6 py-2.5 text-xs font-bold uppercase tracking-widest rounded-xl transition-all duration-300
                               {{ $activeTab === 'ordinance'
                                        ? 'bg-blue-800 text-white shadow-md'
                                        : 'text-slate-400 hover:text-blue-700'
                                    }}"
                    data-target="ordinanceTab" data-tab="ordinance">
                    <i class="fa-solid fa-scale-balanced text-xs"></i>
                    Ordinance
                </button>


                <button type="button" class="tab-btn relative z-10 flex items-center gap-2 px-6 py-2.5 text-xs font-bold uppercase tracking-widest rounded-xl transition-all duration-300
                               {{ $activeTab === 'old_ordinance'
                                        ? 'bg-blue-800 text-white shadow-md'
                                        : 'text-slate-400 hover:text-blue-700'
                                    }}"
                    data-target="oldOrdinanceTab" data-tab="old_ordinance">
                    <i class="fa-solid fa-file-archive text-xs"></i>
                    Old Ordinance
                </button>

                @auth
                <button type="button" class="tab-btn relative z-10 flex items-center gap-2 px-6 py-2.5 text-xs font-bold uppercase tracking-widest rounded-xl transition-all duration-300
                               {{ $activeTab === 'orbus'
                                        ? 'bg-blue-800 text-white shadow-md'
                                        : 'text-slate-400 hover:text-blue-700'
                                    }}"
                    data-target="orbusTab" data-tab="orbus">
                    <i class="fa-solid fa-layer-group text-xs"></i>
                    ORBOS
                </button>

                <button type="button" class="tab-btn relative z-10 flex items-center gap-2 px-6 py-2.5 text-xs font-bold uppercase tracking-widest rounded-xl transition-all duration-300
                               {{ $activeTab === 'old_orbus'
                                        ? 'bg-blue-800 text-white shadow-md'
                                        : 'text-slate-400 hover:text-blue-700'
                                    }}"
                    data-target="oldOrbusTab" data-tab="old_orbus">
                    <i class="fa-solid fa-box-archive text-xs"></i>
                    Old ORBOS
                </button>
                @endauth

                <span id="tabIndicator"
                    class="absolute top-1.5 left-1.5 h-[calc(100%-0.75rem)] bg-blue-800 rounded-xl shadow-md transition-all duration-300 ease-in-out">
                </span>

            </div>
        </div>

        @auth
        {{-- ══ ORBOS TAB ══ --}}
        <div id="orbusTab" class="tab-panel {{ $activeTab === 'orbus' ? '' : 'hidden' }}">
            @if ($records->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @foreach ($records as $group)
                        <div class="group bg-white border border-slate-200 rounded-2xl p-6 shadow-sm
                                    hover:border-blue-400 hover:shadow-lg hover:-translate-y-1
                                    cursor-pointer transition-all duration-300 session-card text-center"
                            data-session="{{ $group['session_key'] }}">

                            <div class="w-12 h-12 rounded-full bg-blue-50 border border-blue-100 flex items-center justify-center mx-auto mb-4
                                        group-hover:bg-blue-800 group-hover:border-blue-800 transition-colors duration-300">
                                <i class="fa-solid fa-file-lines text-blue-700 group-hover:text-white text-sm transition-colors duration-300"></i>
                            </div>

                            <h6 class="font-bold text-blue-900 text-sm mb-1 leading-tight">{{ $group['session_label'] }}</h6>

                            <p class="text-slate-400 text-xs">
                                {{ \Carbon\Carbon::parse($group['date'])->format('F d, Y') }}
                            </p>

                            <div class="mt-4 pt-4 border-t border-slate-100">
                                <span class="text-blue-600 text-xs font-semibold group-hover:text-blue-800 transition-colors">
                                    View Records <i class="fa-solid fa-arrow-right text-[10px] ml-1"></i>
                                </span>
                            </div>

                        </div>
                    @endforeach
                </div>

                {{-- ORBOS Pagination --}}
                @if ($records->hasPages())
                    <div class="flex justify-center mt-8">
                        <nav class="flex items-center gap-1">

                            {{-- Previous --}}
                            @if ($records->onFirstPage())
                                <span class="flex items-center gap-1.5 px-4 py-2 text-xs font-bold uppercase tracking-widest
                                             text-slate-300 bg-white border border-slate-200 rounded-xl cursor-not-allowed select-none">
                                    <i class="fa-solid fa-chevron-left text-[10px]"></i> Prev
                                </span>
                            @else
                                <a href="{{ $records->previousPageUrl() }}"
                                   class="flex items-center gap-1.5 px-4 py-2 text-xs font-bold uppercase tracking-widest
                                          text-slate-500 bg-white border border-slate-200 rounded-xl hover:border-blue-400
                                          hover:text-blue-700 transition-all duration-200">
                                    <i class="fa-solid fa-chevron-left text-[10px]"></i> Prev
                                </a>
                            @endif

                            {{-- Page Numbers --}}
                            @foreach ($records->getUrlRange(1, $records->lastPage()) as $page => $url)
                                @if ($page == $records->currentPage())
                                    <span class="w-9 h-9 flex items-center justify-center text-xs font-bold
                                                 bg-blue-800 text-white rounded-xl shadow-sm shadow-blue-800/30">
                                        {{ $page }}
                                    </span>
                                @else
                                    <a href="{{ $url }}"
                                       class="w-9 h-9 flex items-center justify-center text-xs font-bold
                                              text-slate-500 bg-white border border-slate-200 rounded-xl
                                              hover:border-blue-400 hover:text-blue-700 transition-all duration-200">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach

                            {{-- Next --}}
                            @if ($records->hasMorePages())
                                <a href="{{ $records->nextPageUrl() }}"
                                   class="flex items-center gap-1.5 px-4 py-2 text-xs font-bold uppercase tracking-widest
                                          text-slate-500 bg-white border border-slate-200 rounded-xl hover:border-blue-400
                                          hover:text-blue-700 transition-all duration-200">
                                    Next <i class="fa-solid fa-chevron-right text-[10px]"></i>
                                </a>
                            @else
                                <span class="flex items-center gap-1.5 px-4 py-2 text-xs font-bold uppercase tracking-widest
                                             text-slate-300 bg-white border border-slate-200 rounded-xl cursor-not-allowed select-none">
                                    Next <i class="fa-solid fa-chevron-right text-[10px]"></i>
                                </span>
                            @endif

                        </nav>
                    </div>

                    {{-- Page info --}}
                    <p class="text-center text-slate-400 text-xs mt-3">
                        Showing page {{ $records->currentPage() }} of {{ $records->lastPage() }}
                        &nbsp;•&nbsp; {{ $records->total() }} session groups total
                    </p>
                @endif

            @else
                <div class="text-center py-20">
                    <div class="w-16 h-16 rounded-full bg-slate-100 flex items-center justify-center mx-auto mb-4">
                        <i class="fa-solid fa-folder-open text-slate-300 text-2xl"></i>
                    </div>
                    <p class="text-slate-400 font-semibold">No Records Found</p>
                    <p class="text-slate-300 text-xs mt-1">Try adjusting your search filters.</p>
                </div>
            @endif
        </div>

        {{-- ══ OLD ORBOS TAB ══ --}}
        <div id="oldOrbusTab" class="tab-panel {{ $activeTab === 'old_orbus' ? '' : 'hidden' }}">
            @if ($oldRecords->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @foreach ($oldRecords as $group)
                        <div class="group bg-white border border-slate-200 rounded-2xl p-6 shadow-sm
                                    hover:border-blue-400 hover:shadow-lg hover:-translate-y-1
                                    cursor-pointer transition-all duration-300 session-card text-center"
                            data-session="{{ $group['session_key'] }}">

                            <div class="w-12 h-12 rounded-full bg-blue-50 border border-blue-100 flex items-center justify-center mx-auto mb-4
                                        group-hover:bg-blue-800 group-hover:border-blue-800 transition-colors duration-300">
                                <i class="fa-solid fa-box-archive text-blue-700 group-hover:text-white text-sm transition-colors duration-300"></i>
                            </div>

                            <h6 class="font-bold text-blue-900 text-sm mb-1 leading-tight">{{ $group['session_label'] }}</h6>

                            <p class="text-slate-400 text-xs">
                                {{ \Carbon\Carbon::parse($group['date'])->format('F d, Y') }}
                            </p>

                            <div class="mt-4 pt-4 border-t border-slate-100">
                                <span class="text-blue-600 text-xs font-semibold group-hover:text-blue-800 transition-colors">
                                    View Records <i class="fa-solid fa-arrow-right text-[10px] ml-1"></i>
                                </span>
                            </div>

                        </div>
                    @endforeach
                </div>

                {{-- Old ORBOS Pagination --}}
                @if ($oldRecords->hasPages())
                    <div class="flex justify-center mt-8">
                        <nav class="flex items-center gap-1">

                            @if ($oldRecords->onFirstPage())
                                <span class="flex items-center gap-1.5 px-4 py-2 text-xs font-bold uppercase tracking-widest
                                             text-slate-300 bg-white border border-slate-200 rounded-xl cursor-not-allowed select-none">
                                    <i class="fa-solid fa-chevron-left text-[10px]"></i> Prev
                                </span>
                            @else
                                <a href="{{ $oldRecords->previousPageUrl() }}"
                                   class="flex items-center gap-1.5 px-4 py-2 text-xs font-bold uppercase tracking-widest
                                          text-slate-500 bg-white border border-slate-200 rounded-xl hover:border-blue-400
                                          hover:text-blue-700 transition-all duration-200">
                                    <i class="fa-solid fa-chevron-left text-[10px]"></i> Prev
                                </a>
                            @endif

                            @foreach ($oldRecords->getUrlRange(1, $oldRecords->lastPage()) as $page => $url)
                                @if ($page == $oldRecords->currentPage())
                                    <span class="w-9 h-9 flex items-center justify-center text-xs font-bold
                                                 bg-blue-800 text-white rounded-xl shadow-sm shadow-blue-800/30">
                                        {{ $page }}
                                    </span>
                                @else
                                    <a href="{{ $url }}"
                                       class="w-9 h-9 flex items-center justify-center text-xs font-bold
                                              text-slate-500 bg-white border border-slate-200 rounded-xl
                                              hover:border-blue-400 hover:text-blue-700 transition-all duration-200">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach

                            @if ($oldRecords->hasMorePages())
                                <a href="{{ $oldRecords->nextPageUrl() }}"
                                   class="flex items-center gap-1.5 px-4 py-2 text-xs font-bold uppercase tracking-widest
                                          text-slate-500 bg-white border border-slate-200 rounded-xl hover:border-blue-400
                                          hover:text-blue-700 transition-all duration-200">
                                    Next <i class="fa-solid fa-chevron-right text-[10px]"></i>
                                </a>
                            @else
                                <span class="flex items-center gap-1.5 px-4 py-2 text-xs font-bold uppercase tracking-widest
                                             text-slate-300 bg-white border border-slate-200 rounded-xl cursor-not-allowed select-none">
                                    Next <i class="fa-solid fa-chevron-right text-[10px]"></i>
                                </span>
                            @endif

                        </nav>
                    </div>

                    <p class="text-center text-slate-400 text-xs mt-3">
                        Showing page {{ $oldRecords->currentPage() }} of {{ $oldRecords->lastPage() }}
                        &nbsp;•&nbsp; {{ $oldRecords->total() }} archived session groups total
                    </p>
                @endif

            @else
                <div class="text-center py-20">
                    <div class="w-16 h-16 rounded-full bg-slate-100 flex items-center justify-center mx-auto mb-4">
                        <i class="fa-solid fa-box-archive text-slate-300 text-2xl"></i>
                    </div>
                    <p class="text-slate-400 font-semibold">No Archived Records Found</p>
                    <p class="text-slate-300 text-xs mt-1">Try adjusting your search filters.</p>
                </div>
            @endif
        </div>
        @endauth

        {{-- ══ OLD ORDINANCE TAB ══ --}}
        <div id="oldOrdinanceTab" class="tab-panel {{ $activeTab === 'old_ordinance' ? '' : 'hidden' }}">
            @if ($oldOrdinances->count() > 0)
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-gray-700">
                            <thead>
                                <tr class="bg-blue-900 text-white">
                                    <th class="px-5 py-4 text-left text-xs font-bold uppercase tracking-wider">Title</th>
                                    <th class="px-5 py-4 text-left text-xs font-bold uppercase tracking-wider">Description</th>
                                    <th class="px-5 py-4 text-xs font-bold uppercase tracking-wider">Sponsor</th>
                                    <th class="px-5 py-4 text-xs font-bold uppercase tracking-wider">Action</th>
                                    <th class="px-5 py-4 text-xs font-bold uppercase tracking-wider">Publish Through</th>
                                    <th class="px-5 py-4 text-xs font-bold uppercase tracking-wider">Date Published</th>
                                    <th class="px-5 py-4 text-xs font-bold uppercase tracking-wider">N/A</th>
                                    <th class="px-5 py-4 text-xs font-bold uppercase tracking-wider">View</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach ($oldOrdinances as $index => $ordinance)
                                    <tr class="hover:bg-blue-50/50 transition-colors duration-150 {{ $loop->even ? 'bg-slate-50/50' : 'bg-white' }}">
                                        <td class="px-5 py-4 font-semibold text-blue-900 text-xs max-w-[200px]">
                                            {{ $ordinance->title }}
                                        </td>
                                        <td class="px-5 py-4 text-dark text-xs max-w-[220px] whitespace-pre-wrap break-words">
                                            {{ preg_replace('/^[ \t]+/m', '', $ordinance->description) ?? '—' }}
                                        </td>
                                        <td class="px-5 py-4 text-center text-xs text-slate-600">
                                            {{ $ordinance->sponsor ?? '—' }}
                                        </td>
                                        <td class="px-5 py-4 text-center text-xs text-slate-600">
                                            {{ $ordinance->action ?? '—' }}
                                        </td>
                                        <td class="px-5 py-4 text-center text-xs text-slate-600">
                                            {{ $ordinance->publish_through ?? '—' }}
                                        </td>
                                        <td class="px-5 py-4 text-center text-xs text-slate-500 whitespace-nowrap">
                                            {{ $ordinance->date
                                                ? \Carbon\Carbon::parse($ordinance->date)->format('M d, Y')
                                                : '—' }}
                                        </td>
                                        <td class="px-5 py-4 text-center">
                                            @if ($ordinance->not_applicable)
                                                <span class="inline-flex items-center gap-1 px-2.5 py-1 text-[10px] font-bold
                                                             bg-green-50 text-green-700 border border-green-200 rounded-full uppercase tracking-wide">
                                                    <i class="fa-solid fa-check text-[8px]"></i> N/A
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-1 text-[10px] font-bold
                                                             bg-slate-100 text-slate-400 border border-slate-200 rounded-full uppercase tracking-wide">
                                                    did not set as N/A
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-5 py-4 text-center">
                                            <button type="button"
                                                class="view-old-ordinance-btn inline-flex items-center justify-center px-3 py-2 text-[10px] font-bold uppercase tracking-widest text-white bg-blue-800 rounded-xl hover:bg-blue-700 transition-all duration-200"
                                                data-index="{{ $index }}"
                                                data-source="old">
                                                View
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @if ($oldOrdinances->hasPages())
                    <div class="flex justify-center mt-8">
                        <nav class="flex items-center gap-1">
                            @if ($oldOrdinances->onFirstPage())
                                <span class="flex items-center gap-1.5 px-4 py-2 text-xs font-bold uppercase tracking-widest
                                             text-slate-300 bg-white border border-slate-200 rounded-xl cursor-not-allowed select-none">
                                    <i class="fa-solid fa-chevron-left text-[10px]"></i> Prev
                                </span>
                            @else
                                <a href="{{ $oldOrdinances->previousPageUrl() }}"
                                   class="flex items-center gap-1.5 px-4 py-2 text-xs font-bold uppercase tracking-widest
                                          text-slate-500 bg-white border border-slate-200 rounded-xl hover:border-blue-400
                                          hover:text-blue-700 transition-all duration-200">
                                    <i class="fa-solid fa-chevron-left text-[10px]"></i> Prev
                                </a>
                            @endif
                            @foreach ($oldOrdinances->getUrlRange(1, $oldOrdinances->lastPage()) as $page => $url)
                                @if ($page == $oldOrdinances->currentPage())
                                    <span class="w-9 h-9 flex items-center justify-center text-xs font-bold
                                                 bg-blue-800 text-white rounded-xl shadow-sm shadow-blue-800/30">
                                        {{ $page }}
                                    </span>
                                @else
                                    <a href="{{ $url }}"
                                       class="w-9 h-9 flex items-center justify-center text-xs font-bold
                                              text-slate-500 bg-white border border-slate-200 rounded-xl
                                              hover:border-blue-400 hover:text-blue-700 transition-all duration-200">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach
                            @if ($oldOrdinances->hasMorePages())
                                <a href="{{ $oldOrdinances->nextPageUrl() }}"
                                   class="flex items-center gap-1.5 px-4 py-2 text-xs font-bold uppercase tracking-widest
                                          text-slate-500 bg-white border border-slate-200 rounded-xl hover:border-blue-400
                                          hover:text-blue-700 transition-all duration-200">
                                    Next <i class="fa-solid fa-chevron-right text-[10px]"></i>
                                </a>
                            @else
                                <span class="flex items-center gap-1.5 px-4 py-2 text-xs font-bold uppercase tracking-widest
                                             text-slate-300 bg-white border border-slate-200 rounded-xl cursor-not-allowed select-none">
                                    Next <i class="fa-solid fa-chevron-right text-[10px]"></i>
                                </span>
                            @endif
                        </nav>
                    </div>
                    <p class="text-center text-slate-400 text-xs mt-3">
                        Showing {{ $oldOrdinances->firstItem() }}–{{ $oldOrdinances->lastItem() }} of {{ $oldOrdinances->total() }} old ordinances
                    </p>
                @endif
            @else
                <div class="text-center py-20">
                    <div class="w-16 h-16 rounded-full bg-slate-100 flex items-center justify-center mx-auto mb-4">
                        <i class="fa-solid fa-box-archive text-slate-300 text-2xl"></i>
                    </div>
                    <p class="text-slate-400 font-semibold">No Archived Ordinances Found</p>
                    <p class="text-slate-300 text-xs mt-1">Try adjusting your search filters.</p>
                </div>
            @endif
        </div>



        {{-- ══ ORDINANCE TAB ══════════════════ --}}
        <div id="ordinanceTab" class="tab-panel {{ $activeTab === 'ordinance' ? '' : 'hidden' }}">
            @if ($ordinances->count() > 0)
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-gray-700">
                            <thead>
                                <tr class="bg-blue-900 text-white">
                                    <th class="px-5 py-4 text-left text-xs font-bold uppercase tracking-wider">Title</th>
                                    <th class="px-5 py-4 text-left text-xs font-bold uppercase tracking-wider">Description</th>
                                    <th class="px-5 py-4 text-xs font-bold uppercase tracking-wider">Sponsor</th>
                                    <th class="px-5 py-4 text-xs font-bold uppercase tracking-wider">Action</th>
                                    <th class="px-5 py-4 text-xs font-bold uppercase tracking-wider">Publish Through</th>
                                    <th class="px-5 py-4 text-xs font-bold uppercase tracking-wider">Date Published</th>
                                    <th class="px-5 py-4 text-xs font-bold uppercase tracking-wider">N/A</th>
                                    <th class="px-5 py-4 text-xs font-bold uppercase tracking-wider">View</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach ($ordinances as $index => $ordinance)
                                    <tr class="hover:bg-blue-50/50 transition-colors duration-150 {{ $loop->even ? 'bg-slate-50/50' : 'bg-white' }}">

                                        <td class="px-5 py-4 font-semibold text-blue-900 text-xs max-w-[200px]">
                                            {{ $ordinance->title }}
                                        </td>

                                        <td class="px-5 py-4 text-dark text-xs max-w-[220px] whitespace-pre-wrap break-words">
                                            {{ preg_replace("/\s+/", " ", trim($ordinance->description)) ?: '—' }}
                                        </td>

                                        <td class="px-5 py-4 text-center text-xs text-slate-600">
                                            {{ $ordinance->sponsor ?? '—' }}
                                        </td>

                                        <td class="px-5 py-4 text-center text-xs text-slate-600">
                                            {{ $ordinance->action ?? '—' }}
                                        </td>

                                        <td class="px-5 py-4 text-center text-xs text-slate-600">
                                            {{ $ordinance->publish_through ?? '—' }}
                                        </td>

                                        <td class="px-5 py-4 text-center text-xs text-slate-500 whitespace-nowrap">
                                            {{ $ordinance->date
                                                ? \Carbon\Carbon::parse($ordinance->date)->format('M d, Y')
                                                : '—' }}
                                        </td>

                                        <td class="px-5 py-4 text-center">
                                            @if ($ordinance->not_applicable)
                                                <span class="inline-flex items-center gap-1 px-2.5 py-1 text-[10px] font-bold
                                                             bg-green-50 text-green-700 border border-green-200 rounded-full uppercase tracking-wide">
                                                    <i class="fa-solid fa-check text-[8px]"></i> N/A
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-1 text-[10px] font-bold
                                                             bg-slate-100 text-slate-400 border border-slate-200 rounded-full uppercase tracking-wide">
                                                    did not set as N/A
                                                </span>
                                            @endif
                                        </td>

                                        <td class="px-5 py-4 text-center">
                                            <button type="button"
                                                class="view-ordinance-btn inline-flex items-center justify-center px-3 py-2 text-[10px] font-bold uppercase tracking-widest text-white bg-blue-800 rounded-xl hover:bg-blue-700 transition-all duration-200"
                                                data-index="{{ $index }}">
                                                View
                                            </button>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Ordinance Pagination --}}
                @if ($ordinances->hasPages())
                    <div class="flex justify-center mt-8">
                        <nav class="flex items-center gap-1">

                            {{-- Previous --}}
                            @if ($ordinances->onFirstPage())
                                <span class="flex items-center gap-1.5 px-4 py-2 text-xs font-bold uppercase tracking-widest
                                             text-slate-300 bg-white border border-slate-200 rounded-xl cursor-not-allowed select-none">
                                    <i class="fa-solid fa-chevron-left text-[10px]"></i> Prev
                                </span>
                            @else
                                <a href="{{ $ordinances->previousPageUrl() }}"
                                   class="flex items-center gap-1.5 px-4 py-2 text-xs font-bold uppercase tracking-widest
                                          text-slate-500 bg-white border border-slate-200 rounded-xl hover:border-blue-400
                                          hover:text-blue-700 transition-all duration-200">
                                    <i class="fa-solid fa-chevron-left text-[10px]"></i> Prev
                                </a>
                            @endif

                            {{-- Page Numbers --}}
                            @foreach ($ordinances->getUrlRange(1, $ordinances->lastPage()) as $page => $url)
                                @if ($page == $ordinances->currentPage())
                                    <span class="w-9 h-9 flex items-center justify-center text-xs font-bold
                                                 bg-blue-800 text-white rounded-xl shadow-sm shadow-blue-800/30">
                                        {{ $page }}
                                    </span>
                                @else
                                    <a href="{{ $url }}"
                                       class="w-9 h-9 flex items-center justify-center text-xs font-bold
                                              text-slate-500 bg-white border border-slate-200 rounded-xl
                                              hover:border-blue-400 hover:text-blue-700 transition-all duration-200">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach

                            {{-- Next --}}
                            @if ($ordinances->hasMorePages())
                                <a href="{{ $ordinances->nextPageUrl() }}"
                                   class="flex items-center gap-1.5 px-4 py-2 text-xs font-bold uppercase tracking-widest
                                          text-slate-500 bg-white border border-slate-200 rounded-xl hover:border-blue-400
                                          hover:text-blue-700 transition-all duration-200">
                                    Next <i class="fa-solid fa-chevron-right text-[10px]"></i>
                                </a>
                            @else
                                <span class="flex items-center gap-1.5 px-4 py-2 text-xs font-bold uppercase tracking-widest
                                             text-slate-300 bg-white border border-slate-200 rounded-xl cursor-not-allowed select-none">
                                    Next <i class="fa-solid fa-chevron-right text-[10px]"></i>
                                </span>
                            @endif

                        </nav>
                    </div>

                    {{-- Page info --}}
                    <p class="text-center text-slate-400 text-xs mt-3">
                        Showing {{ $ordinances->firstItem() }}–{{ $ordinances->lastItem() }} of {{ $ordinances->total() }} ordinances
                    </p>
                @endif

            @else
                <div class="text-center py-20">
                    <div class="w-16 h-16 rounded-full bg-slate-100 flex items-center justify-center mx-auto mb-4">
                        <i class="fa-solid fa-scale-balanced text-slate-300 text-2xl"></i>
                    </div>
                    <p class="text-slate-400 font-semibold">No Ordinances Found</p>
                    <p class="text-slate-300 text-xs mt-1">Try adjusting your search filters.</p>
                </div>
            @endif
        </div>

    </div>
</div>

{{-- ══════════════════ MODAL ══════════════════ --}}
<div id="legislativeModal"
    class="fixed inset-0 z-50 hidden items-center justify-center bg-black/60 backdrop-blur-sm p-4">

    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-5xl max-h-[90vh] flex flex-col overflow-hidden border border-slate-200">

        {{-- Modal Header --}}
        <div class="relative bg-blue-900 px-6 py-5 flex-shrink-0">
            <button id="modal-close"
                class="absolute top-4 right-4 w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 flex items-center justify-center text-white transition-colors">
                <i class="fa-solid fa-xmark text-sm"></i>
            </button>

            <div class="text-center">
                <p class="text-white/50 text-[10px] tracking-[0.3em] uppercase mb-1">
                    Republic of the Philippines • Province of Leyte • Municipality of Hilongos
                </p>
                <h5 class="text-white font-bold text-base" style="font-family: 'Playfair Display', serif;">
                    Legislative Tracking System
                </h5>
                <p class="text-green-300 text-xs mt-1.5">
                    <strong id="modal-session-title"></strong>
                    <span class="text-white/30 mx-2">•</span>
                    <span id="modal-session-date" class="text-white/60"></span>
                </p>
            </div>
        </div>

        {{-- Modal Body --}}
        <div class="overflow-auto flex-1">
            <table class="w-full text-sm text-gray-700">
                <thead class="sticky top-0 bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="px-5 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Session</th>
                        <th class="px-5 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Date</th>
                        <th class="px-5 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Legislative Records</th>
                        <th class="px-5 py-3 text-xs font-bold text-slate-500 uppercase tracking-wider">Sponsor</th>
                        <th class="px-5 py-3 text-xs font-bold text-slate-500 uppercase tracking-wider">Action Taken</th>
                    </tr>
                </thead>
                <tbody id="modal-table-body" class="divide-y divide-slate-100 bg-white"></tbody>
            </table>
        </div>

    </div>
</div>

{{-- ══════════════════ ORDINANCE MODAL ══════════════════ --}}
<div id="ordinanceModal"
    class="fixed inset-0 z-50 hidden items-center justify-center bg-black/60 backdrop-blur-sm p-4">

    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-5xl max-h-[90vh] flex flex-col overflow-hidden border border-slate-200">

        <div class="relative bg-blue-900 px-6 py-5 flex-shrink-0">
            <button id="ordinance-modal-close"
                class="absolute top-4 right-4 w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 flex items-center justify-center text-white transition-colors">
                <i class="fa-solid fa-xmark text-sm"></i>
            </button>

            <div class="text-center">
                <p class="text-white/50 text-[10px] tracking-[0.3em] uppercase mb-1">
                    Republic of the Philippines • Province of Leyte • Municipality of Hilongos
                </p>
                <h5 class="text-white font-bold text-base" style="font-family: 'Playfair Display', serif;">
                    Ordinance Details
                </h5>
                <p class="text-green-300 text-xs mt-1.5">
                    <strong id="ordinance-modal-title"></strong>
                    <span class="text-white/30 mx-2">•</span>
                    <span id="ordinance-modal-date" class="text-white/60"></span>
                </p>
            </div>
        </div>

        <div class="overflow-auto flex-1">
            <table class="w-full text-sm text-gray-700">
                <thead class="sticky top-0 bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="px-5 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Title</th>
                        <th class="px-5 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Description</th>
                        <th class="px-5 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Sponsor</th>
                        <th class="px-5 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Action</th>
                        <th class="px-5 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Publish Through</th>
                        <th class="px-5 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">N/A</th>
                    </tr>
                </thead>
                <tbody id="ordinance-modal-body" class="divide-y divide-slate-100 bg-white"></tbody>
            </table>
        </div>

    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {

        const tabInput  = document.getElementById('activeTab');
        const tabBtns   = document.querySelectorAll('.tab-btn');
        const tabPanels = document.querySelectorAll('.tab-panel');
        const indicator = document.getElementById('tabIndicator');

        function moveIndicator(el) {
            indicator.style.width = el.offsetWidth + 'px';
            indicator.style.left  = el.offsetLeft  + 'px';
        }

        const activeBtn = Array.from(tabBtns).find(btn => btn.dataset.tab === tabInput.value) || tabBtns[0];

        if (activeBtn) {
            tabBtns.forEach(btn => {
                if (btn === activeBtn) {
                    btn.classList.remove('text-slate-400');
                    btn.classList.add('bg-blue-800', 'text-white', 'shadow-md');
                } else {
                            btn.classList.add('text-slate-400');
                }
            });

            tabPanels.forEach(p => p.classList.add('hidden'));
            document.getElementById(activeBtn.dataset.target)?.classList.remove('hidden');

            setTimeout(() => moveIndicator(activeBtn), 50);
            tabInput.value = activeBtn.dataset.tab;
        }

        tabBtns.forEach(btn => {
            btn.addEventListener('click', function () {
                tabInput.value = this.dataset.tab;

                tabPanels.forEach(p => p.classList.add('hidden'));
                document.getElementById(this.dataset.target).classList.remove('hidden');

                tabBtns.forEach(b => {
                    b.classList.remove('bg-blue-800', 'text-white', 'shadow-md');
                    b.classList.add('text-slate-400');
                });

                this.classList.remove('text-slate-400');
                this.classList.add('bg-blue-800', 'text-white', 'shadow-md');
                moveIndicator(this);
            });
        });

        // Modal — only pass current page's items to JS
        const rawSessionData = [
            ...@json($records->items()),
            ...@json($oldRecords->items()),
        ];
        const sessionData = {};
        rawSessionData.forEach(group => {
            sessionData[group.session_key] = group;
        });
        const modal = document.getElementById('legislativeModal');
        const tbody = document.getElementById('modal-table-body');
        const modalTitle = document.getElementById('modal-session-title');
        const modalDate = document.getElementById('modal-session-date');

        const formattedDescription = (desc) => {
            if (!desc) return '';
            return desc
                .replace(/\r\n/g, '\n')
                .replace(/\r/g, '\n')
                .replace(/^\s+/, '')
                .replace(/(^|\n)\s+/g, '$1')
                .replace(/(^|\n)([-*•]|\d+\.)\s*/g, '$1  $2 ');
        };

        const ordinanceData = @json($ordinances->items());
        const oldOrdinanceData = @json($oldOrdinances->items());
        const ordinanceModal = document.getElementById('ordinanceModal');
        const ordinanceTbody = document.getElementById('ordinance-modal-body');
        const ordinanceModalTitle = document.getElementById('ordinance-modal-title');
        const ordinanceModalDate = document.getElementById('ordinance-modal-date');

        document.querySelectorAll('.session-card').forEach(card => {
            card.addEventListener('click', function () {
                const sessionKey = this.dataset.session;
                const group      = sessionData[sessionKey] || { records: [], session_label: '', date: '' };

                modalTitle.textContent = group.session_label;
                modalDate.textContent  = new Date(group.date).toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' });
                tbody.innerHTML = '';

                group.records.forEach((row, i) => {
                    const descriptionText = formattedDescription(row.description || '');

                    tbody.innerHTML += `
                        <tr class="hover:bg-blue-50/40 transition-colors ${i % 2 === 0 ? 'bg-white' : 'bg-slate-50/50'}">
                            <td class="px-5 py-3 text-xs text-slate-600">${row.session}</td>
                            <td class="px-5 py-3 text-xs text-slate-600 whitespace-nowrap">${new Date(row.date).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })}</td>
                            <td class="px-5 py-3 text-left align-top">
                                <p class="font-semibold text-blue-900 text-xs">${row.title}</p>
                                <p class="text-dark text-xs font-bold mt-0.5 whitespace-pre-wrap break-words">${descriptionText}</p>
                            </td>
                            <td class="px-5 py-3 text-center text-xs text-slate-600">${row.sponsor || '—'}</td>
                            <td class="px-5 py-3 text-center text-xs text-slate-600">${row.action_taken || '—'}</td>
                        </tr>`;
                });

                modal.classList.remove('hidden');
                modal.classList.add('flex');
            });
        });

        document.querySelectorAll('.view-ordinance-btn, .view-old-ordinance-btn').forEach(button => {
            button.addEventListener('click', function () {
                const index = Number(this.dataset.index);
                const source = this.dataset.source || 'current';
                const record = source === 'old' ? oldOrdinanceData[index] || {} : ordinanceData[index] || {};

                const descriptionText = formattedDescription(record.description || '');
                const publishThrough = record.publish_through || '—';
                const actionText = record.action || '—';
                const sponsorText = record.sponsor || '—';
                const naText = record.not_applicable ? 'N/A' : 'No';

                ordinanceModalTitle.textContent = record.title || 'Ordinance';
                ordinanceModalDate.textContent = record.date
                    ? new Date(record.date).toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' })
                    : '—';

                ordinanceTbody.innerHTML = `
                    <tr class="bg-white">
                        <td class="px-5 py-3 text-xs text-slate-600 align-top">${record.title || '—'}</td>
                        <td class="px-5 py-3 text-left text-dark text-xs whitespace-pre-wrap break-words">${descriptionText || '—'}</td>
                        <td class="px-5 py-3 text-left text-slate-600 text-xs">${sponsorText}</td>
                        <td class="px-5 py-3 text-left text-slate-600 text-xs">${actionText}</td>
                        <td class="px-5 py-3 text-left text-slate-600 text-xs">${publishThrough}</td>
                        <td class="px-5 py-3 text-left text-slate-600 text-xs">${naText}</td>
                    </tr>`;

                ordinanceModal.classList.remove('hidden');
                ordinanceModal.classList.add('flex');
            });
        });

        document.getElementById('modal-close').onclick = () => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        };

        modal.addEventListener('click', function (e) {
            if (e.target === modal) {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }
        });

        document.getElementById('ordinance-modal-close').onclick = () => {
            ordinanceModal.classList.add('hidden');
            ordinanceModal.classList.remove('flex');
        };

        ordinanceModal.addEventListener('click', function (e) {
            if (e.target === ordinanceModal) {
                ordinanceModal.classList.add('hidden');
                ordinanceModal.classList.remove('flex');
            }
        });

    });
</script>
@endpush

@endsection
