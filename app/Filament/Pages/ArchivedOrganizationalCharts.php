<?php

namespace App\Filament\Pages;

use App\Models\OrganizationalChart;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;

class ArchivedOrganizationalCharts extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-archive-box';
    protected static string $view = 'filament.pages.archived-organizational-charts';
    protected static ?string $navigationGroup = 'Documents';
    protected static ?string $navigationLabel = 'Archived Organizational Charts';
    protected static ?int $navigationSort = 17;

    public function table(Table $table): Table
    {
        return $table
            ->query(OrganizationalChart::query()->where('is_archived', true))
            ->columns([

                TextColumn::make('title')
                    ->label('Title')
                    ->searchable()
                    ->sortable(),

                ImageColumn::make('file')
                    ->label('Chart Preview')
                    ->disk('public')
                    ->defaultImageUrl(asset('images/default.jpg'))
                    ->height(80),

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
                    ->modalHeading('Restore Organizational Chart')
                    ->modalDescription('Are you sure you would like to restore this organizational chart?')
                    ->modalSubmitActionLabel('Restore')
                    ->action(function (OrganizationalChart $record) {
                        $record->update([
                            'is_archived' => false,
                        ]);

                        Notification::make()
                            ->title('Organizational Chart Restored')
                            ->body('The organizational chart has been restored successfully.')
                            ->success()
                            ->send();
                    }),

                Tables\Actions\DeleteAction::make()
                    ->label('Delete Permanently')
                    ->icon('heroicon-o-trash')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading('Delete Organizational Chart Permanently')
                    ->modalDescription('Are you sure you want to permanently delete this organizational chart? This action cannot be undone.')
                    ->modalSubmitActionLabel('Delete')
                    ->action(function (OrganizationalChart $record) {
                        $record->delete();

                        Notification::make()
                            ->title('Organizational Chart Deleted')
                            ->body('The organizational chart has been permanently deleted.')
                            ->success()
                            ->send();
                    }),
            ]);
    }
}
