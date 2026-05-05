<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\Ordinance;
use Filament\Tables;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Notifications\Notification;

class ArchivedOrdinances extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-archive-box';
    protected static string $view = 'filament.pages.archived-ordinances';
    protected static ?int $navigationSort = 4;
    protected static ?string $navigationGroup = 'Ordinance';
    protected static ?string $navigationLabel = 'Archived Ordinances';

    public function table(Table $table): Table
    {
        return $table
            ->query(Ordinance::query()->where('is_archived', true))
            ->columns([

                TextColumn::make('title')
                    ->searchable(),

                TextColumn::make('description')
                    ->searchable(),

                Tables\Columns\TextColumn::make('sponsor')
                    ->label('Sponsor')
                    ->searchable(),

                Tables\Columns\TextColumn::make('action')
                    ->label('Action taken'),

                TextColumn::make('publish_through')
                    ->searchable(),

                Tables\Columns\TextColumn::make('date')
                    ->label('Date Published')
                    ->formatStateUsing(function ($state) {
                        return $state
                            ? \Carbon\Carbon::parse($state)->format('M d, Y')
                            : 'No Date Published';
                    })
                    ->sortable(),

                TextColumn::make('file')
                    ->label('PDF')
                    ->formatStateUsing(fn ($state) => $state ? '📄 View PDF' : 'No File')
                    ->url(fn ($record) =>
                        $record->file ? asset('storage/' . $record->file) : null
                    )
                    ->openUrlInNewTab(),
            ])

            ->actions([

                Tables\Actions\Action::make('preview')
                    ->label('Preview')
                    ->icon('heroicon-o-eye')
                    ->modalHeading('PDF Preview')
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Close')
                    ->modalContent(function ($record) {
                        $url = asset('storage/' . $record->file);

                        return view('filament.preview.pdf', compact('url'));
                    }),

                Tables\Actions\Action::make('restore')
                    ->label('Restore')
                    ->icon('heroicon-o-arrow-uturn-left')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Restore Ordinance')
                    ->modalDescription('Are you sure you would like to restore this ordinance?')
                    ->modalSubmitActionLabel('Restore')
                    ->action(function ($record) {
                        $record->update([
                            'is_archived' => false,
                        ]);

                        Notification::make()
                            ->title('Ordinance Restored')
                            ->body('The ordinance has been restored successfully.')
                            ->success()
                            ->send();
                    }),
            ]);
    }
}
