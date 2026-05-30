<?php

namespace App\Filament\Pages;

use App\Models\AuditLog;
use App\Models\User;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ArchivedAuditLogs extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-archive-box';

    protected static string $view = 'filament.pages.archived-audit-logs';

    protected static ?string $navigationGroup = 'Admin Activities';

    protected static ?string $navigationLabel = 'Archived Audit Logs';

    protected static ?int $navigationSort = 17;

    public static function canAccess(): bool
    {
        return auth()->user()?->role === User::ADMIN;
    }

    public static function shouldRegisterNavigation(): bool
    {
        return static::canAccess();
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(AuditLog::query()->where('is_archived', true)->latest('attempted_at'))
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),
                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable(),

                // ADD HERE
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

                // END ADD

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
                    ->label('Challenge')
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
                        ->where('is_archived', true)
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
                        ->where('is_archived', true)
                        ->whereNotNull('attempted_at')
                        ->orderBy('attempted_at', 'desc')
                        ->pluck('attempted_at')
                        ->map(fn ($date) => \Carbon\Carbon::parse($date)->toDateString())
                        ->unique()
                        ->mapWithKeys(fn ($date) => [
                            $date => \Carbon\Carbon::parse($date)->toFormattedDateString()
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
                Tables\Actions\Action::make('restore')
                    ->label('Restore')
                    ->icon('heroicon-o-arrow-uturn-left')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Restore Audit Log')
                    ->modalDescription('Are you sure you would like to restore this audit log?')
                    ->modalSubmitActionLabel('Restore')
                    ->action(function (AuditLog $record) {
                        $record->update([
                            'is_archived' => false,
                        ]);

                        Notification::make()
                            ->title('Audit Log Restored')
                            ->body('The audit log has been restored successfully.')
                            ->success()
                            ->send();
                    }),

                Tables\Actions\DeleteAction::make()
                    ->label('Delete Permanently')
                    ->icon('heroicon-o-trash')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading('Delete Audit Log Permanently')
                    ->modalDescription('Are you sure you want to permanently delete this audit log? This action cannot be undone.')
                    ->modalSubmitActionLabel('Delete')
                    ->action(function (AuditLog $record) {
                        $record->delete();

                        Notification::make()
                            ->title('Audit Log Deleted')
                            ->body('The audit log has been permanently deleted.')
                            ->success()
                            ->send();
                    }),
            ])
            ->bulkActions([
                    Tables\Actions\BulkAction::make('restore')
                        ->label('Restore Selected')
                        ->icon('heroicon-o-arrow-uturn-left')
                        ->color('success')
                        ->requiresConfirmation()
                        ->modalHeading('Restore Audit Logs')
                        ->modalDescription('Are you sure you want to restore the selected audit logs?')
                        ->modalSubmitActionLabel('Restore')
                        ->action(function (\Illuminate\Support\Collection $records, HasTable $livewire) {

                            foreach ($records as $record) {
                                $record->update([
                                    'is_archived' => false,
                                ]);
                            }

                            // ✅ REFRESHER (important)
                            $livewire->deselectAllTableRecords();

                            Notification::make()
                                ->title('Audit Logs Restored')
                                ->body('Selected audit logs have been restored successfully.')
                                ->success()
                                ->send();
                        }),

                    Tables\Actions\DeleteBulkAction::make()
                        ->label('Delete Permanently')
                        ->icon('heroicon-o-trash')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->modalHeading('Delete Audit Logs Permanently')
                        ->modalDescription('Are you sure you want to permanently delete the selected audit logs? This action cannot be undone.')
                        ->modalSubmitActionLabel('Delete')
                        ->successNotificationTitle('Selected audit logs have been permanently deleted.'),
            ])
            ->defaultSort('attempted_at', 'desc');
    }
}
