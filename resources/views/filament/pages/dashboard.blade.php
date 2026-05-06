<x-filament-panels::page>

    {{-- TOP RIGHT STATS + TOGGLE --}}
    <div class="flex mb-6">
        <div class="fi-card p-5 rounded-xl flex items-center gap-8 ml-auto">

            <div>
                <p class="text-sm text-gray-500">ORBOS Records</p>
                <p class="text-2xl font-bold">
                    {{ \App\Models\LegislativeRecord::count() }}
                </p>
            </div>

            <div>
                <p class="text-sm text-gray-500">Ordinances</p>
                <p class="text-2xl font-bold">
                    {{ \App\Models\Ordinance::count() }}
                </p>
            </div>

            <div>
                <p class="text-sm text-gray-500">Announcements</p>
                <p class="text-2xl font-bold">
                    {{ \App\Models\Announcement::query()->where('is_archived', false)->where('published', true)->count() }}
                </p>
            </div>

            <div class="w-px h-10 bg-gray-300 dark:bg-gray-600"></div>

            <div class="flex gap-2">
                <button
                    wire:click="$set('activeTab', 'orbus')"
                    class="px-4 py-2 rounded-lg text-sm font-medium
                        {{ $activeTab === 'orbus'
                            ? 'bg-primary-600 text-white'
                            : 'bg-gray-200 dark:bg-gray-700' }}">
                    ORBOS
                </button>

                <button
                    wire:click="$set('activeTab', 'ordinance')"
                    class="px-4 py-2 rounded-lg text-sm font-medium
                        {{ $activeTab === 'ordinance'
                            ? 'bg-primary-600 text-white'
                            : 'bg-gray-200 dark:bg-gray-700' }}">
                    Ordinances
                </button>

                <button
                    wire:click="$set('activeTab', 'announcements')"
                    class="px-4 py-2 rounded-lg text-sm font-medium
                        {{ $activeTab === 'announcements'
                            ? 'bg-primary-600 text-white'
                            : 'bg-gray-200 dark:bg-gray-700' }}">
                    Announcements
                </button>
            </div>

        </div>
    </div>

    {{-- ✅ RENDER WIDGETS CORRECTLY --}}
    @if ($activeTab === 'orbus')
        @livewire(\App\Filament\Widgets\RecentLegislativeRecords::class)
    @endif

    @if ($activeTab === 'ordinance')
        @livewire(\App\Filament\Widgets\RecentOrdinances::class)
    @endif

    @if ($activeTab === 'announcements')
        @livewire(\App\Filament\Widgets\RecentAnnouncements::class)
    @endif

</x-filament-panels::page>
