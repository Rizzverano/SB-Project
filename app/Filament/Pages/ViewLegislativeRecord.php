<?php

namespace App\Filament\Pages;

use App\Enums\Permission;
use App\Models\LegislativeRecord as LegislativeRecordModel;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Concerns\InteractsWithInfolists;
use Filament\Infolists\Contracts\HasInfolists;
use Filament\Infolists\Infolist;
use Filament\Pages\Page;

class ViewLegislativeRecord extends Page implements HasInfolists
{
    use InteractsWithInfolists;

    protected static ?string $navigationIcon = 'heroicon-o-eye';

    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $slug = 'dashboard/legislative-records/{record}';

    protected static string $view = 'filament.pages.view-legislative-record';

    protected static ?string $title = 'View Orbus Record';

    public LegislativeRecordModel $record;

    public function mount(LegislativeRecordModel $record): void
    {
        $this->record = $record;
    }

    public static function canAccess(): bool
    {
        $user = auth()->user();

        if (!$user) {
            return false;
        }

        return $user->hasPermission(Permission::DASHBOARD);
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->record($this->record)
            ->schema([
                Section::make('Legislative record overview')
                    ->description('Complete session context, authorship, and action status for this legislative entry.')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('session')
                                    ->label('Session')
                                    ->badge()
                                    ->color('info'),
                                TextEntry::make('date')
                                    ->label('Session date')
                                    ->date('F d, Y'),
                            ]),
                        TextEntry::make('title')
                            ->label('Title')
                            ->weight('bold')
                            ->size(TextEntry\TextEntrySize::Large)
                            ->columnSpanFull(),
                        TextEntry::make('description')
                            ->label('Description')
                            ->markdown()
                            ->placeholder('No description provided.')
                            ->prose()
                            ->columnSpanFull(),
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('sponsor')
                                    ->label('Sponsor')
                                    ->placeholder('Not specified'),
                                TextEntry::make('action_taken')
                                    ->label('Action taken')
                                    ->badge()
                                    ->color(
                                        fn ($state) => match ($state) {
                                            'Approved' => 'success',
                                            'Marked as Noted' => 'gray',
                                            'NONE' => 'secondary',
                                            default => 'warning',
                                        },
                                    ),
                            ]),
                    ])
                    ->extraAttributes([
                        'class' => 'mx-auto max-w-5xl',
                    ]),
            ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('back')
                ->label('Back to Dashboard')
                ->icon('heroicon-o-arrow-left')
                ->url(Dashboard::getUrl()),
        ];
    }
}
