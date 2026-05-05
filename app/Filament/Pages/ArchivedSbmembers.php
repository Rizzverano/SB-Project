<?php

namespace App\Filament\Pages;

use App\Models\Sbmember;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Tables;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;

class ArchivedSbmembers extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static string $view = 'filament.pages.archived-sbmembers';
    protected static ?string $navigationGroup = 'Officials';
    protected static ?string $navigationLabel = 'Former SB Members';
    protected static ?int $navigationSort = 13;

    public function getTitle(): string
    {
        return 'Former SB Members';
    }

    public function getHeading(): string
    {
        return 'Former SB Members';
    }

    public function getBreadcrumb(): string
    {
        return 'Former SB Members';
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(Sbmember::query()->where('is_archived', true)->latest())
            ->columns([
                ImageColumn::make('image')
                    ->label('Image')
                    ->defaultImageUrl(asset('images/default.jpg')),
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('description')
                    ->limit(50),
                CheckboxColumn::make('is_publish')
                    ->label('Published')
                    ->sortable()
                    ->toggleable(),
            ])
            ->actions([
                Tables\Actions\Action::make('restore')
                    ->label('Restore')
                    ->icon('heroicon-o-arrow-uturn-left')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Restore SB Member')
                    ->modalDescription('Are you sure you would like to restore this SB member?')
                    ->modalSubmitActionLabel('Restore')
                    ->action(function (Sbmember $record) {
                        $record->update([
                            'is_archived' => false,
                        ]);

                        Notification::make()
                            ->title('SB Member Restored')
                            ->body('The SB member has been restored successfully.')
                            ->success()
                            ->send();
                    }),
            ]);
    }
}
