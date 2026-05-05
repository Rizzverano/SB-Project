<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\LegislativeRecord;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\Action;
use Filament\Notifications\Notification;

class ArchivedLegislativeRecords extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-archive-box';
    protected static ?string $navigationLabel = 'Archived ORBOS';
    protected static ?string $navigationGroup = 'ORBOS';
    protected static ?int $navigationSort = 2;
    protected static string $view = 'filament.pages.archived-legislative-records';

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
            ->query(LegislativeRecord::onlyTrashed()->latest())
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
            ->actions([
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
