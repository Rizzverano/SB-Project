<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\Announcement;
use Filament\Tables;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Notifications\Notification;

class ArchivedAnnouncements extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-archive-box';
    protected static string $view = 'filament.pages.archived-announcements';
    protected static ?string $navigationGroup = 'Events';
    protected static ?string $navigationLabel = 'Archived Announcements';
    protected static ?int $navigationSort = 7;

    public function table(Table $table): Table
    {
        return $table
            ->query(Announcement::query()->where('is_archived', true))
            ->columns([
                TextColumn::make('title')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('description')
                    ->limit(50)
                    ->wrap(),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\Action::make('restore')
                    ->label('Restore')
                    ->icon('heroicon-o-arrow-uturn-left')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Restore Announcement')
                    ->modalDescription('Are you sure you would like to restore this announcement?')
                    ->modalSubmitActionLabel('Restore')
                    ->action(function ($record) {
                        $record->update([
                            'is_archived' => false,
                        ]);

                        Notification::make()
                            ->title('Announcement Restored')
                            ->body('The announcement has been restored successfully.')
                            ->success()
                            ->send();
                    }),

                Tables\Actions\DeleteAction::make()->
                    label('Delete Permanently')
                    ->icon('heroicon-o-trash')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading('Delete Announcement Permanently')
                    ->modalDescription('Are you sure you want to permanently delete this announcement? This action cannot be undone.')
                    ->modalSubmitActionLabel('Delete')
                    ->action(function ($record) {
                        $record->delete();

                        Notification::make()
                            ->title('Announcement Deleted')
                            ->body('The announcement has been permanently deleted.')
                            ->success()
                            ->send();
                    }),
            ]);
    }
}
