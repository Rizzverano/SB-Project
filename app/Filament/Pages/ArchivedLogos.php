<?php

namespace App\Filament\Pages;

use App\Models\Logo;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;

class ArchivedLogos extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-archive-box';
    protected static string $view = 'filament.pages.archived-logos';
    protected static ?string $navigationGroup = 'Gov Logos';
    protected static ?string $navigationLabel = 'Archived Logo Sets';
    protected static ?int $navigationSort = 11;

    public function table(Table $table): Table
    {
        return $table
            ->query(Logo::query()->where('is_archived', true)->latest())
            ->columns([
                TextColumn::make('id')
                    ->label('Set')
                    ->formatStateUsing(fn (Logo $record) => 'Logo Set #' . $record->id)
                    ->badge()
                    ->color('gray')
                    ->sortable(),
                ImageColumn::make('pres_gov')
                    ->label('Provincial')
                    ->disk('public')
                    ->square()
                    ->size(72),
                ImageColumn::make('lgu_hilongos')
                    ->label('LGU')
                    ->disk('public')
                    ->square()
                    ->size(72),
                IconColumn::make('is_published')
                    ->label('Active')
                    ->boolean()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime('M d, Y h:i A')
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\Action::make('restore')
                    ->label('Restore')
                    ->icon('heroicon-o-arrow-uturn-left')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Restore Logo Set')
                    ->modalDescription('Are you sure you would like to restore this logo set?')
                    ->modalSubmitActionLabel('Restore')
                    ->action(function (Logo $record) {
                        $record->update([
                            'is_archived' => false,
                        ]);

                        Notification::make()
                            ->title('Logo Set Restored')
                            ->body('The logo set has been restored successfully.')
                            ->success()
                            ->send();
                    }),
                Tables\Actions\DeleteAction::make()
                    ->label('Delete Permanently')
                    ->icon('heroicon-o-trash')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading('Delete Logo Set Permanently')
                    ->modalDescription('Are you sure you want to permanently delete this logo set? This action cannot be undone.')
                    ->modalSubmitActionLabel('Delete')
                    ->action(function (Logo $record) {
                        $record->delete();

                        Notification::make()
                            ->title('Logo Set Deleted')
                            ->body('The logo set has been permanently deleted.')
                            ->success()
                            ->send();
                    }),
            ]);
    }
}
