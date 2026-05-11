<x-filament-panels::page>

    {{-- TOP RIGHT STATS + TOGGLE --}}
    <div class="flex mb-6">
        <div
            class="fi-card p-4 sm:p-5 rounded-xl flex flex-wrap items-center gap-4 sm:gap-8 w-full sm:w-auto sm:ml-auto">

            {{-- Stats: hidden on small screens --}}
            <div class="hidden sm:flex items-center gap-8">
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

                <div>
                    <p class="text-sm text-gray-500">SB Members</p>
                    <p class="text-2xl font-bold">
                        {{ \App\Models\SbMember::query()->where('is_archived', false)->count() }}
                    </p>
                </div>

                <div class="w-px h-10 bg-gray-300 dark:bg-gray-600"></div>
            </div>

            {{-- Tab buttons: always visible --}}
            <div class="flex gap-2 w-full sm:w-auto">
                <button wire:click="$set('activeTab', 'orbus')"
                    class="flex-1 sm:flex-none px-2 py-1.5 sm:px-4 sm:py-2 rounded-lg text-xs sm:text-sm font-medium transition-colors
            {{ $activeTab === 'orbus'
                ? 'bg-primary-600 text-white'
                : 'bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-300 dark:hover:bg-gray-600' }}">
                    ORBOS
                </button>

                <button wire:click="$set('activeTab', 'ordinance')"
                    class="flex-1 sm:flex-none px-2 py-1.5 sm:px-4 sm:py-2 rounded-lg text-xs sm:text-sm font-medium transition-colors
            {{ $activeTab === 'ordinance'
                ? 'bg-primary-600 text-white'
                : 'bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-300 dark:hover:bg-gray-600' }}">
                    Ordinances
                </button>

                <button wire:click="$set('activeTab', 'announcements')"
                    class="flex-1 sm:flex-none px-2 py-1.5 sm:px-4 sm:py-2 rounded-lg text-xs sm:text-sm font-medium transition-colors
            {{ $activeTab === 'announcements'
                ? 'bg-primary-600 text-white'
                : 'bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-300 dark:hover:bg-gray-600' }}">
                    Announcements
                </button>
            </div>

        </div>
    </div>

    {{-- RENDER WIDGETS --}}
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
