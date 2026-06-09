<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ArchivedAuditLogResource\Pages;
use App\Models\AuditLog;
use App\Models\User;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ArchivedAuditLogResource extends Resource
{
    protected static ?string $model = AuditLog::class;

    protected static ?string $navigationIcon = 'heroicon-o-archive-box';

    protected static ?string $navigationGroup = 'Admin Activities';

    protected static ?string $navigationLabel = 'Archived Audit Logs';

    protected static ?string $modelLabel = 'Archived Audit Log';

    protected static ?int $navigationSort = 25;

    public static function canViewAny(): bool
    {
        return auth()->user()?->role === User::ADMIN;
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit($record): bool
    {
        return false;
    }

    public static function canView($record): bool
    {
        return auth()->user()?->role === User::ADMIN;
    }

    public static function canDelete($record): bool
    {
        return auth()->user()?->role === User::ADMIN;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('attempted_at', 'desc')
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),
                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable(),

                    // Add
                TextColumn::make('action')
                    ->badge()
                    ->sortable(),

                TextColumn::make('module')
                    ->badge()
                    ->color('info'),

                TextColumn::make('performed_by')
                    ->label('Performed By')
                    ->searchable(),

                TextColumn::make('description')
                    ->limit(50)
                    ->tooltip(fn ($record) => $record->description),

                    // End

                TextColumn::make('ip_address')
                    ->label('IP Address')
                    ->searchable(),
                TextColumn::make('user_agent')
                    ->label('User Agent')
                    ->limit(60)
                    ->tooltip(fn (AuditLog $record): ?string => $record->user_agent),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        AuditLog::STATUS_SUCCESS => 'success',
                        AuditLog::STATUS_FAILED => 'danger',
                        default => 'gray',
                    })
                    ->sortable(),
                TextColumn::make('failure_reason')
                    ->label('Failure Reason')
                    ->placeholder('-')
                    ->badge()
                    ->color('warning'),
                IconColumn::make('is_locked')
                    ->label('Locked')
                    ->boolean(),
                IconColumn::make('has_challenge')
                    ->label('Challenge/OTP')
                    ->boolean(),
                TextColumn::make('attempted_at')
                    ->label('Attempted At')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        AuditLog::STATUS_SUCCESS => 'Success',
                        AuditLog::STATUS_FAILED  => 'Failed',
                    ])
                    ->searchable()
                    ->preload(),

                SelectFilter::make('failure_reason')
                    ->label('Filter by Failure Reason')
                    ->options(fn (): array => AuditLog::query()
                        ->whereNotNull('failure_reason')
                        ->distinct()
                        ->orderBy('failure_reason')
                        ->pluck('failure_reason', 'failure_reason')
                        ->all())
                    ->searchable()
                    ->preload(),

                SelectFilter::make('attempted_at')
                    ->label('Filter by Date')
                    ->options(fn (): array => AuditLog::query()
                        ->whereNotNull('attempted_at')
                        ->distinct()
                        ->orderBy('attempted_at', 'desc')
                        ->pluck('attempted_at')
                        ->map(fn ($date) => \Carbon\Carbon::parse($date)->toDateString())
                        ->unique()
                        ->mapWithKeys(fn ($date) => [
                            $date => \Carbon\Carbon::parse($date)->toFormattedDateString(),
                        ])
                        ->all())
                    ->searchable()
                    ->preload()
                    ->query(fn ($query, array $data) => $query->when(
                        $data['value'],
                        fn ($q) => $q->whereDate('attempted_at', $data['value'])
                    )),
            ])
            ->filtersLayout(Tables\Enums\FiltersLayout::AboveContent)
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->color('info')
                    ->modal()
                    ->infolist([
                        \Filament\Infolists\Components\Section::make('Audit Details') // renamed for clarity
                            ->schema([
                                \Filament\Infolists\Components\Grid::make(3)
                                    ->schema([

                                        // ✅ ADD THESE
                                        \Filament\Infolists\Components\TextEntry::make('action')
                                            ->badge(),

                                        \Filament\Infolists\Components\TextEntry::make('module')
                                            ->badge()
                                            ->color('info'),

                                        \Filament\Infolists\Components\TextEntry::make('performed_by')
                                            ->label('Performed By'),

                                        \Filament\Infolists\Components\TextEntry::make('description')
                                            ->columnSpanFull(),

                                        // EXISTING
                                        \Filament\Infolists\Components\TextEntry::make('email')
                                            ->label('Email'),

                                        \Filament\Infolists\Components\TextEntry::make('status')
                                            ->badge()
                                            ->color(fn (string $state): string => match ($state) {
                                                'success' => 'success',
                                                'failed'  => 'danger',
                                                default   => 'gray',
                                            }),

                                        \Filament\Infolists\Components\TextEntry::make('ip_address')
                                            ->label('IP Address'),

                                        \Filament\Infolists\Components\TextEntry::make('attempted_at')
                                            ->label('Attempted At')
                                            ->dateTime(),

                                        \Filament\Infolists\Components\TextEntry::make('failure_reason')
                                            ->label('Failure Reason')
                                            ->placeholder('-')
                                            ->badge()
                                            ->color('warning'),

                                        \Filament\Infolists\Components\IconEntry::make('is_locked')
                                            ->label('Locked')
                                            ->boolean(),

                                        \Filament\Infolists\Components\IconEntry::make('has_challenge')
                                            ->label('Challenge')
                                            ->boolean(),
                                    ]),

                                \Filament\Infolists\Components\TextEntry::make('user_agent')
                                    ->label('User Agent')
                                    ->columnSpanFull(),
                            ]),
                    ]),

                Action::make('restore')
                    ->label('Restore')
                    ->icon('heroicon-o-arrow-left-on-rectangle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Restore Archived Audit Log')
                    ->modalDescription('Are you sure you want to restore this audit log entry?')
                    ->modalSubmitActionLabel('Restore')
                    ->action(function (AuditLog $record) {
                        $record->update([
                            'is_archived' => false,
                        ]);
                    }),

                DeleteAction::make()
                    ->label('Delete Permanently')
                    ->icon('heroicon-o-trash')
                    ->color('danger')
                    ->requiresConfirmation(),
            ])
            ->bulkActions([
                BulkAction::make('restore')
                    ->label('Restore Selected')
                    ->icon('heroicon-o-arrow-left-on-rectangle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Restore Selected Audit Logs')
                    ->modalDescription('Are you sure you want to restore the selected archived audit log entries?')
                    ->modalSubmitActionLabel('Restore')
                    ->action(function ($records, $livewire) {
                        $records->each->update([
                            'is_archived' => false,
                        ]);

                        $livewire->deselectAllTableRecords();
                    }),

                DeleteBulkAction::make()
                    ->label('Delete Permanently Selected')
                    ->icon('heroicon-o-trash')
                    ->color('danger')
                    ->requiresConfirmation(),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('is_archived', true)
            ->latest('attempted_at');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListArchivedAuditLogs::route('/'),
        ];
    }
}
