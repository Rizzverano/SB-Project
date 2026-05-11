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
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\Grid;

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
                    ->searchable()
                    ->limit(50),
                CheckboxColumn::make('is_publish')
                    ->label('Published')
                    ->sortable()
                    ->toggleable(),
            ])
            ->striped()
            ->paginated([10, 25, 50])
            ->actions([
                Tables\Actions\Action::make('view')
                    ->label('View')
                    ->icon('heroicon-o-eye')
                    ->color('info')
                    ->modalHeading(fn (Sbmember $record) => $record->name)
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Close')
                    ->infolist(fn (Infolist $infolist, Sbmember $record) => $infolist
                        ->record($record)
                        ->schema([
                            Section::make()
                                ->schema([
                                    Grid::make(3)
                                        ->schema([
                                            ImageEntry::make('image')
                                                ->label('')
                                                ->defaultImageUrl(asset('images/default.jpg'))
                                                ->height(160)
                                                ->columnSpan(1),

                                            Section::make()
                                                ->schema([
                                                    TextEntry::make('name')
                                                        ->label('Full Name')
                                                        ->weight('bold')
                                                        ->size(TextEntry\TextEntrySize::Large),

                                                    TextEntry::make('description')
                                                        ->label('Position / Role')
                                                        ->prose(),

                                                    TextEntry::make('is_publish')
                                                        ->label('Visibility')
                                                        ->formatStateUsing(fn ($state) => $state ? 'Published' : 'Unpublished')
                                                        ->badge()
                                                        ->color(fn ($state) => $state ? 'success' : 'gray'),
                                                ])
                                                ->columnSpan(2),
                                        ]),
                                ]),
                        ])
                    ),

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
