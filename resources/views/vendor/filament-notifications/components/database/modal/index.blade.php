@props([
    'notifications',
    'unreadNotificationsCount',
])

@php
    use Filament\Support\Enums\Alignment;

    $hasNotifications = $notifications->count();
    $isPaginated = $notifications instanceof \Illuminate\Contracts\Pagination\Paginator && $notifications->hasPages();
@endphp

<x-filament::modal
    :alignment="$hasNotifications ? null : Alignment::Center"
    close-button
    :description="$hasNotifications ? null : __('filament-notifications::database.modal.empty.description')"
    :heading="$hasNotifications ? null : __('filament-notifications::database.modal.empty.heading')"
    :icon="$hasNotifications ? null : 'heroicon-o-bell-slash'"
    :icon-alias="$hasNotifications ? null : 'notifications::database.modal.empty-state'"
    :icon-color="$hasNotifications ? null : 'gray'"
    id="database-notifications"
    slide-over
    :sticky-header="$hasNotifications"
    width="md"
>
    @if ($hasNotifications)
        <x-slot name="header">
            <div class="space-y-3">
                <div>
                    <x-filament::modal.heading>
                        Notifications
                    </x-filament::modal.heading>

                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        {{ $unreadNotificationsCount }} unread
                    </p>
                </div>

                <x-filament-notifications::database.modal.actions
                    :notifications="$notifications"
                    :unread-notifications-count="$unreadNotificationsCount"
                />
            </div>
        </x-slot>

        <div
            @class([
                '-mx-6 -mt-6 space-y-3 bg-gray-50 p-4 dark:bg-gray-950',
                '-mb-6' => ! $isPaginated,
                'border-b border-gray-200 dark:border-white/10' => $isPaginated,
            ])
        >
            @foreach ($notifications as $notification)
                @php
                    $data = $notification->data;
                    $viewData = $data['viewData'] ?? [];
                    $url = $viewData['url'] ?? null;
                    $module = $viewData['module'] ?? null;
                    $icon = $data['icon'] ?? 'heroicon-o-bell';
                    $title = $data['title'] ?? 'Notification';
                    $body = $data['body'] ?? null;
                @endphp

                @if ($url)
                    <a
                        href="{{ $url }}"
                        x-data
                        x-on:click.prevent="
                            $wire.markNotificationAsRead('{{ $notification->getKey() }}').then(() => {
                                window.location.href = '{{ $url }}';
                            });
                        "
                    @class([
                        'group block rounded-lg border p-4 shadow-sm transition',
                        'border-primary-500/40 bg-primary-50 dark:border-primary-400/40 dark:bg-primary-400/10' => $notification->unread(),
                        'border-gray-200 bg-white hover:border-primary-400 hover:bg-gray-50 dark:border-white/10 dark:bg-gray-900 dark:hover:border-primary-500/60 dark:hover:bg-white/5' => $notification->read(),
                        ])
                    >
                @else
                    <div
                    @class([
                        'group block rounded-lg border p-4 shadow-sm transition',
                        'border-primary-500/40 bg-primary-50 dark:border-primary-400/40 dark:bg-primary-400/10' => $notification->unread(),
                        'border-gray-200 bg-white hover:border-primary-400 hover:bg-gray-50 dark:border-white/10 dark:bg-gray-900 dark:hover:border-primary-500/60 dark:hover:bg-white/5' => $notification->read(),
                    ])
                    >
                @endif
                    <div class="flex items-start gap-3">
                        <div class="mt-0.5 flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-primary-100 text-primary-700 dark:bg-primary-500/20 dark:text-primary-300">
                            <x-filament::icon
                                :icon="$icon"
                                class="h-5 w-5"
                            />
                        </div>

                        <div class="min-w-0 flex-1">
                            <div class="flex items-start justify-between gap-3">
                                <p class="truncate text-sm font-semibold text-gray-950 dark:text-white">
                                    {{ str($title)->sanitizeHtml()->toHtmlString() }}
                                </p>

                                @if ($module)
                                    <span class="shrink-0 rounded-md bg-primary-600/10 px-2 py-1 text-xs font-medium text-primary-700 dark:bg-primary-400/10 dark:text-primary-300">
                                        {{ $module }}
                                    </span>
                                @endif
                            </div>

                            @if ($body)
                                <p class="mt-1 line-clamp-3 text-sm leading-6 text-gray-600 dark:text-gray-300">
                                    {{ str($body)->sanitizeHtml()->toHtmlString() }}
                                </p>
                            @endif

                            <p class="mt-3 text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                                {{ $notification->created_at?->diffForHumans() }}
                            </p>
                        </div>
                    </div>

                @if ($url)
                    </a>
                @else
                    </div>
                @endif
            @endforeach
        </div>

        @if ($isPaginated)
            <x-slot name="footer">
                <x-filament::pagination :paginator="$notifications" />
            </x-slot>
        @endif
    @endif
</x-filament::modal>
