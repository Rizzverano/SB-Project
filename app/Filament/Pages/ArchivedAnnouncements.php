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
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\Grid;

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
                    ->searchable()
                    ->wrap(),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->striped()
            ->paginated([10, 25, 50])
            ->actions([
                Tables\Actions\Action::make('view')
                    ->label('View')
                    ->icon('heroicon-o-eye')
                    ->color('info')
                    ->modalHeading(fn (Announcement $record) => $record->title)
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Close')
                    ->infolist(fn (Infolist $infolist, Announcement $record) => $infolist
                        ->record($record)
                        ->schema([
                            Section::make('Announcement Details')
                                ->icon('heroicon-o-megaphone')
                                ->schema([
                                    TextEntry::make('title')
                                        ->label('Title')
                                        ->weight('bold')
                                        ->size(TextEntry\TextEntrySize::Large)
                                        ->columnSpanFull(),

                                    TextEntry::make('description')
                                        ->label('Description')
                                        ->prose()
                                        ->placeholder('No description provided.')
                                        ->columnSpanFull(),
                                ]),

                            Section::make('Timestamps')
                                ->icon('heroicon-o-clock')
                                ->schema([
                                    Grid::make(2)
                                        ->schema([
                                            TextEntry::make('created_at')
                                                ->label('Created At')
                                                ->dateTime('F d, Y h:i A'),

                                            TextEntry::make('updated_at')
                                                ->label('Last Updated')
                                                ->dateTime('F d, Y h:i A'),
                                        ]),
                                ])
                                ->collapsed(),
                        ])
                    ),

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

                Tables\Actions\DeleteAction::make()
                    ->label('Delete Permanently')
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
            ])
            ->bulkActions([
            Tables\Actions\BulkAction::make('bulk_restore')
                ->label('Bulk Restore')
                ->icon('heroicon-o-arrow-uturn-left')
                ->color('success')
                ->requiresConfirmation()
                ->modalHeading('Restore Selected Announcements')
                ->modalDescription('Are you sure you want to restore the selected announcements?')
                ->modalSubmitActionLabel('Restore All')
                ->action(function (\Illuminate\Support\Collection $records, HasTable $livewire) {

                    foreach ($records as $record) {
                        $record->update([
                            'is_archived' => false,
                        ]);
                    }

                    // ✅ REFRESHER (clear selected rows)
                    $livewire->deselectAllTableRecords();

                    Notification::make()
                        ->title('Announcements Restored')
                        ->body('Selected announcements have been restored successfully.')
                        ->success()
                        ->send();
                }),

            Tables\Actions\BulkAction::make('bulk_delete')
                ->label('Bulk Delete')
                ->icon('heroicon-o-trash')
                ->color('danger')
                ->requiresConfirmation()
                ->modalHeading('Delete Selected Announcements')
                ->modalDescription('This will permanently delete the selected announcements. This action cannot be undone.')
                ->modalSubmitActionLabel('Delete All')
                ->action(function (\Illuminate\Support\Collection $records, HasTable $livewire) {

                    foreach ($records as $record) {
                        $record->delete();
                    }

                    // ✅ REFRESHER (clear selected rows)
                    $livewire->deselectAllTableRecords();

                    Notification::make()
                        ->title('Announcements Deleted')
                        ->body('Selected announcements have been permanently deleted.')
                        ->success()
                        ->send();
                }),

        ]);
    }
}
