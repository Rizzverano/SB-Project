@extends('layout.layout')

@section('content')
    <div class="px-6 py-8 bg-gray-100 border border-slate-200 rounded-xl shadow-md mx-4 my-6">

        <!-- TITLE + SEARCH -->
        <div class="flex flex-wrap justify-between items-start gap-4 mb-6">

            <h4 class="text-2xl md:text-3xl font-bold text-blue-900">
                All Legislative Records
            </h4>

            <form method="GET" action="{{ route('legislative_index') }}">
                @csrf
                <input type="hidden" name="tab" id="activeTab" value="{{ request('tab', 'orbus') }}">

                <div class="flex flex-wrap gap-2 items-center">

                    <input type="text" name="session" value="{{ request('session') }}" placeholder="Search Session/Title"
                        class="bg-white text-gray-700 border border-slate-300 rounded-lg px-3 py-2 text-sm
                    focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">

                    <input type="date" name="date" value="{{ request('date') }}"
                        class="bg-white text-gray-700 border border-slate-300 rounded-lg px-3 py-2 text-sm
                    focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">

                    <button type="submit"
                        class="bg-blue-700 hover:bg-blue-600 text-white text-sm font-semibold px-4 py-2 rounded-lg transition">
                        Search
                    </button>

                    <a href="{{ route('legislative_index') }}"
                        class="border border-blue-700 text-blue-700 hover:bg-blue-700 hover:text-white text-sm font-semibold px-4 py-2 rounded-lg transition">
                        Reset
                    </a>

                </div>
            </form>
        </div>

        <!-- TABS -->
        <div class="flex gap-1 border-b border-slate-200 mb-6">

            <button
                class="tab-btn px-5 py-2.5 text-sm font-semibold rounded-t-lg border-b-2 transition
            {{ $activeTab === 'orbus' ? 'border-blue-600 text-blue-700 bg-blue-50' : 'border-transparent text-gray-500 hover:text-blue-700 hover:border-blue-300' }}"
                data-target="orbusTab" data-tab="orbus">
                ORBUS
            </button>

            <button
                class="tab-btn px-5 py-2.5 text-sm font-semibold rounded-t-lg border-b-2 transition
            {{ $activeTab === 'ordinance' ? 'border-blue-600 text-blue-700 bg-blue-50' : 'border-transparent text-gray-500 hover:text-blue-700 hover:border-blue-300' }}"
                data-target="ordinanceTab" data-tab="ordinance">
                Ordinance
            </button>

        </div>

        <!-- ORBUS TAB -->
        <div id="orbusTab" class="tab-panel {{ $activeTab === 'orbus' ? '' : 'hidden' }}">

            @if ($records && count($records) > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">

                    @foreach ($records as $session => $items)
                        <div class="bg-indigo-100 border border-slate-200 rounded-xl text-center p-5 shadow-sm
                hover:border-blue-500 hover:shadow-md hover:-translate-y-0.5
                cursor-pointer transition-all duration-200 session-card"
                            data-session="{{ $session }}">

                            <h6 class="font-semibold text-blue-900 text-sm mb-1">{{ $session }}</h6>

                            <p class="text-gray-500 text-xs">
                                {{ \Carbon\Carbon::parse($items[0]['date'])->format('F d, Y') }}
                            </p>

                        </div>
                    @endforeach

                </div>
            @else
                <div class="text-center py-10 text-gray-500">
                    <p class="text-lg font-semibold">No Record Found</p>
                </div>
            @endif

        </div>

        <!-- ORDINANCE TAB -->
        <div id="ordinanceTab" class="tab-panel {{ $activeTab === 'ordinance' ? '' : 'hidden' }}">

            @if ($ordinances && count($ordinances) > 0)
                <div class="overflow-x-auto rounded-xl border border-slate-200">
                    <table class="w-full text-sm text-center text-gray-700">

                        <thead class="bg-blue-700 text-white font-semibold">
                            <tr>
                                <th class="px-4 py-3">Title</th>
                                <th class="px-4 py-3">Description</th>
                                <th class="px-4 py-3">Sponsor</th>
                                <th class="px-4 py-3">Action</th>
                                <th class="px-4 py-3">Publish Through</th>
                                <th class="px-4 py-3">Date</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-200 bg-white">
                            @foreach ($ordinances as $ordinance)
                                <tr
                                    class="hover:bg-slate-50 transition {{ $loop->even ? 'bg-indigo-100' : 'bg-slate-100' }}">

                                    <td class="px-4 py-3 text-left font-semibold">
                                        {{ $ordinance->title }}
                                    </td>

                                    <td class="px-4 py-3 text-left">
                                        {{ $ordinance->description ?? '-' }}
                                    </td>

                                    <td class="px-4 py-3">
                                        {{ $ordinance->sponsor ?? '-' }}
                                    </td>

                                    <td class="px-4 py-3">
                                        {{ $ordinance->action ?? '-' }}
                                    </td>

                                    <td class="px-4 py-3">
                                        {{ $ordinance->publish_through ?? '-' }}
                                    </td>

                                    <td class="px-4 py-3">
                                        {{ $ordinance->date ? \Carbon\Carbon::parse($ordinance->date)->format('F d, Y') : '-' }}
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
            @else
                <div class="text-center py-10 text-gray-500">
                    <p class="text-lg font-semibold">No Record Found</p>
                </div>
            @endif

        </div>

        <!-- footer -->
        <div class="flex justify-end mt-8">
        </div>

    </div>

    <!-- MODAL -->
    <div id="legislativeModal"
        class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm p-4">

        <div class="bg-white border border-slate-200 rounded-xl shadow-xl w-full max-w-6xl max-h-[90vh] flex flex-col">

            <!-- HEADER -->
            <div class="relative text-center border-b border-slate-200 px-6 py-4">

                <button id="modal-close" class="absolute top-3 right-4 text-gray-500 hover:text-black text-xl">
                    <i class="fa-solid fa-xmark"></i>
                </button>

                <p class="text-xs text-gray-500">Republic of the Philippines</p>
                <p class="text-xs text-gray-500">Province of Leyte</p>
                <p class="text-xs text-gray-500">Municipality of Hilongos</p>

                <h5 class="font-bold text-blue-900 mt-1">LEGISLATIVE TRACKING SYSTEM</h5>

                <p class="text-sm text-blue-700 mt-1">
                    <strong id="modal-session-title"></strong>
                    <span class="text-gray-400 mx-1">—</span>
                    <span id="modal-session-date"></span>
                </p>

            </div>

            <!-- BODY -->
            <div class="overflow-auto flex-1">
                <table class="w-full text-sm text-center text-gray-700">

                    <thead class="bg-blue-700 text-white font-semibold sticky top-0">
                        <tr>
                            <th class="px-4 py-3">Session</th>
                            <th class="px-4 py-3">Date</th>
                            <th class="px-4 py-3">Legislative Record</th>
                            <th class="px-4 py-3">Reported / Sponsored</th>
                            <th class="px-4 py-3">Action Taken</th>
                        </tr>
                    </thead>

                    <tbody id="modal-table-body" class="divide-y divide-slate-200 bg-white"></tbody>

                </table>
            </div>

            <div class="py-2 mt-6"></div>

        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {

                const tabInput = document.getElementById('activeTab');
                const tabBtns = document.querySelectorAll('.tab-btn');
                const tabPanels = document.querySelectorAll('.tab-panel');

                tabBtns.forEach(btn => {
                    btn.addEventListener('click', function() {
                        const target = this.dataset.target;
                        const tab = this.dataset.tab;

                        tabInput.value = tab;

                        tabPanels.forEach(p => p.classList.add('hidden'));
                        document.getElementById(target).classList.remove('hidden');

                        tabBtns.forEach(b => {
                            b.classList.remove('border-blue-600', 'text-blue-700',
                                'bg-blue-50');
                            b.classList.add('border-transparent', 'text-gray-500');
                        });

                        this.classList.add('border-blue-600', 'text-blue-700', 'bg-blue-50');
                    });
                });

                const sessionData = @json($records);
                const modal = document.getElementById('legislativeModal');
                const tbody = document.getElementById('modal-table-body');

                document.querySelectorAll('.session-card').forEach(card => {
                    card.addEventListener('click', function() {
                        const session = this.dataset.session;
                        const rows = sessionData[session] || [];

                        tbody.innerHTML = '';

                        rows.forEach(row => {
                            tbody.innerHTML += `
                    <tr>
                        <td class="px-4 py-3">${row.session}</td>
                        <td class="px-4 py-3">${new Date(row.date).toLocaleDateString()}</td>
                        <td class="px-4 py-3 text-left">
                            <strong>${row.title}</strong><br>
                            <span class="text-gray-500 text-xs">${row.description ?? ''}</span>
                        </td>
                        <td class="px-4 py-3">${row.sponsor || '-'}</td>
                        <td class="px-4 py-3">${row.action_taken || '-'}</td>
                    </tr>`;
                        });

                        modal.classList.remove('hidden');
                        modal.classList.add('flex');
                    });
                });

                document.getElementById('modal-close').onclick = () => {
                    modal.classList.add('hidden');
                };

            });

            function printFile(url) {
                const win = window.open(url, '_blank');
                win.print();
            }
        </script>
    @endpush
@endsection
