<?php

namespace App\Filament\Pages;

use App\Models\CitizensCharter;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;

class ArchivedCitizensCharters extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-archive-box';
    protected static string $view = 'filament.pages.archived-citizens-charters';
    protected static ?string $navigationGroup = 'Documents';
    protected static ?string $navigationLabel = 'Archived Citizens Charters';
    protected static ?int $navigationSort = 16;

    public function table(Table $table): Table
    {
        return $table
            ->query(CitizensCharter::query()->where('is_archived', true))
            ->columns([

                TextColumn::make('title')
                    ->label('Title')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('file')
                    ->label('Document')
                    ->formatStateUsing(fn ($state) => $state ? '📄View PDF' : 'No File')
                    ->url(fn (CitizensCharter $record) => $record->file
                        ? asset('storage/' . $record->file)
                        : null)
                    ->openUrlInNewTab()
                    ->color('primary'),

                IconColumn::make('is_publish')
                    ->label('Published')
                    ->boolean()
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Uploaded Date')
                    ->dateTime('F d, Y h:i A')
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\Action::make('restore')
                    ->label('Restore')
                    ->icon('heroicon-o-arrow-uturn-left')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Restore Citizens Charter')
                    ->modalDescription('Are you sure you would like to restore this citizens charter?')
                    ->modalSubmitActionLabel('Restore')
                    ->action(function (CitizensCharter $record) {
                        $record->update([
                            'is_archived' => false,
                        ]);

                        Notification::make()
                            ->title('Citizens Charter Restored')
                            ->body('The citizens charter has been restored successfully.')
                            ->success()
                            ->send();
                    }),

                Tables\Actions\DeleteAction::make()
                    ->label('Delete Permanently')
                    ->icon('heroicon-o-trash')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading('Delete Citizens Charter Permanently')
                    ->modalDescription('Are you sure you want to permanently delete this citizens charter? This action cannot be undone.')
                    ->modalSubmitActionLabel('Delete')
                    ->action(function (CitizensCharter $record) {
                        $record->delete();

                        Notification::make()
                            ->title('Citizens Charter Deleted')
                            ->body('The citizens charter has been permanently deleted.')
                            ->success()
                            ->send();
                    }),
            ]);
    }
}
