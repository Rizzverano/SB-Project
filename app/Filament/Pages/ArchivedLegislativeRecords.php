<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\LegislativeRecord;
use Illuminate\Support\Facades\Session;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Tables;
use Filament\Forms;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\Grid;


class ArchivedLegislativeRecords extends Page implements HasTable
{
    use InteractsWithTable;

    public bool $accessGranted = false;

    public ?string $archivePassword = null;

    protected static ?string $navigationIcon = 'heroicon-o-archive-box';
    protected static ?string $navigationLabel = 'Archived ORBOS';
    protected static ?string $navigationGroup = 'ORBOS';
    protected static ?int $navigationSort = 2;
    protected static string $view = 'filament.pages.archived-legislative-records';

    public function mount(): void
    {
        $this->accessGranted = session()->get('orbos_archive_access', false);
    }

    public function verifyPassword(): void
    {
        $correctPassword = env('ARCHIVE_ORBOS_PASSWORD');

        if ($this->archivePassword !== $correctPassword) {

            Notification::make()
                ->title('Invalid Password')
                ->danger()
                ->send();

            return;
        }

        session()->put('orbos_archive_access', true);

        $this->accessGranted = true;

        Notification::make()
            ->title('Access Granted')
            ->success()
            ->send();
    }

    public function getTitle(): string
    {
        return 'Archived ORBOS Records';
    }

    public function getHeading(): string
    {
        return 'Archived ORBOS Records';
    }

    public function getBreadcrumb(): string
    {
        return 'Archived ORBOS Records';
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                    $this->accessGranted
                    ? LegislativeRecord::onlyTrashed()->latest()
                    : LegislativeRecord::query()->whereRaw('1 = 0')
                    )
            ->columns([
                TextColumn::make('session')
                    ->label('Session')
                    ->searchable(),
                TextColumn::make('date')
                    ->label('Date')
                    ->date('F d, Y')
                    ->sortable(),
                TextColumn::make('title')
                    ->label('Title')
                    ->searchable()
                    ->wrap(),
                TextColumn::make('description')
                    ->label('Description')
                    ->limit(100)
                    ->wrap(),
                TextColumn::make('sponsor')
                    ->label('Sponsor')
                    ->searchable(),
                TextColumn::make('action_taken')
                    ->label('Action Taken')
                    ->badge()
                    ->color('warning'),
            ])
            ->striped()
            ->paginated([10, 25, 50])
            ->filters([
                Tables\Filters\SelectFilter::make('session')
                    ->label('Filter by Session')
                    ->options(
                        \App\Models\LegislativeRecord::whereNotNull('session')
                            ->distinct()
                            ->orderBy('session')
                            ->pluck('session', 'session')
                            ->toArray()
                    )
                    ->searchable()
                    ->preload(),

                Tables\Filters\SelectFilter::make('sponsor')
                    ->label('Filter by Sponsor')
                    ->options(
                        \App\Models\LegislativeRecord::whereNotNull('sponsor')
                            ->distinct()
                            ->orderBy('sponsor')
                            ->pluck('sponsor', 'sponsor')
                            ->toArray()
                    )
                    ->searchable()
                    ->preload(),

                Tables\Filters\Filter::make('date_range')
                    ->form([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\DatePicker::make('date_from')
                                    ->label('From')
                                    ->placeholder('Start date')
                                    ->native(false),
                                Forms\Components\DatePicker::make('date_until')
                                    ->label('Until')
                                    ->placeholder('End date')
                                    ->native(false),
                            ]),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when(
                                $data['date_from'],
                                fn ($q) => $q->whereDate('date', '>=', $data['date_from'])
                            )
                            ->when(
                                $data['date_until'],
                                fn ($q) => $q->whereDate('date', '<=', $data['date_until'])
                            );
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];

                        if ($data['date_from'] ?? null) {
                            $indicators[] = Tables\Filters\Indicator::make(
                                'From ' . \Carbon\Carbon::parse($data['date_from'])->toFormattedDateString()
                            )->removeField('date_from');
                        }

                        if ($data['date_until'] ?? null) {
                            $indicators[] = Tables\Filters\Indicator::make(
                                'Until ' . \Carbon\Carbon::parse($data['date_until'])->toFormattedDateString()
                            )->removeField('date_until');
                        }

                        return $indicators;
                    }),
            ])
            ->filtersLayout(Tables\Enums\FiltersLayout::AboveContent)
            ->actions([
                Action::make('view')
                    ->label('View')
                    ->icon('heroicon-o-eye')
                    ->color('info')
                    ->modalHeading(fn (LegislativeRecord $record) => $record->title)
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Close')
                    ->infolist(fn (Infolist $infolist, LegislativeRecord $record) => $infolist
                        ->record($record)
                        ->schema([

                            Section::make('Session Information')
                                ->icon('heroicon-o-calendar-days')
                                ->schema([
                                    Grid::make(2)
                                        ->schema([
                                            TextEntry::make('session')
                                                ->label('Session')
                                                ->badge()
                                                ->color('info'),

                                            TextEntry::make('date')
                                                ->label('Date of Session')
                                                ->date('F d, Y'),
                                        ]),
                                ]),

                            Section::make('Legislative Content')
                                ->icon('heroicon-o-document-text')
                                ->schema([
                                    TextEntry::make('title')
                                        ->label('Title')
                                        ->weight('bold')
                                        ->size(TextEntry\TextEntrySize::Large)
                                        ->columnSpanFull(),

                                    TextEntry::make('description')
                                        ->label('Description / Body')
                                        ->markdown()
                                        ->prose()
                                        ->placeholder('No description provided.')
                                        ->columnSpanFull(),
                                ]),

                            Section::make('Authorship & Resolution')
                                ->icon('heroicon-o-user-circle')
                                ->schema([
                                    Grid::make(2)
                                        ->schema([
                                            TextEntry::make('sponsor')
                                                ->label('Authored / Sponsored by')
                                                ->icon('heroicon-o-user')
                                                ->placeholder('Not specified'),

                                            TextEntry::make('action_taken')
                                                ->label('Resolution / Action Taken')
                                                ->badge()
                                                ->color(
                                                    fn ($state) => match ($state) {
                                                        'Approved'        => 'success',
                                                        'Marked as Noted' => 'gray',
                                                        'NONE'            => 'secondary',
                                                        default           => 'warning',
                                                    }
                                                ),
                                        ]),
                                ]),

                        ])
                    ),

                Action::make('restore')
                    ->label('Restore')
                    ->color('success')
                    ->modalHeading('Restore Legislative Record')
                    ->modalDescription('Are you sure you would like to restore this legislative record?')
                    ->modalSubmitActionLabel('Restore')
                    ->icon('heroicon-o-arrow-uturn-left')
                    ->action(function ($record) {
                        $record->restore();
                        Notification::make()
                            ->title('Legislative Record Restored')
                            ->body('The legislative record has been restored successfully.')
                            ->success()
                            ->send();
                    })
                    ->requiresConfirmation(),
            ])
            ->defaultSort('date', 'desc');
    }
}
