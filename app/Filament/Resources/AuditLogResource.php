<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AuditLogResource\Pages;
use App\Models\AuditLog;
use App\Models\User;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class AuditLogResource extends Resource
{
    protected static ?string $model = AuditLog::class;

    protected static ?string $navigationIcon = 'heroicon-o-shield-check';

    protected static ?string $navigationGroup = 'Admin Activities';

    protected static ?string $navigationLabel = 'Audit Logs';

    protected static ?string $modelLabel = 'Audit Log';

    protected static ?int $navigationSort = 18;

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
                        AuditLog::STATUS_FAILED => 'Failed',
                    ]),
                SelectFilter::make('failure_reason')
                    ->options(fn (): array => AuditLog::query()
                        ->whereNotNull('failure_reason')
                        ->distinct()
                        ->orderBy('failure_reason')
                        ->pluck('failure_reason', 'failure_reason')
                        ->all()),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->color('info'),

                Tables\Actions\DeleteAction::make()
                    ->requiresConfirmation()
                    ->modalHeading('Delete Audit Log')
                    ->modalDescription('Are you sure you want to delete this audit log? This action cannot be undone.')
                    ->modalSubmitActionLabel('Yes, Delete')
                    ->successNotificationTitle('Audit log deleted successfully.'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make()
                        ->requiresConfirmation()
                        ->modalHeading('Delete Selected Audit Logs')
                        ->modalDescription('Are you sure you want to delete the selected audit logs? This action cannot be undone.')
                        ->modalSubmitActionLabel('Yes, Delete Selected')
                        ->successNotificationTitle('Selected audit logs deleted successfully.'),
                ]),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->latest('attempted_at');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAuditLogs::route('/'),
            'view' => Pages\ViewAuditLog::route('/{record}'),
        ];
    }
}
