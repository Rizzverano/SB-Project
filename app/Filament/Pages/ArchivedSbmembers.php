<?php

namespace App\Filament\Pages;

use App\Filament\Concerns\RequiresStaffAccess;
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
    use RequiresStaffAccess;
    use InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static string $view = 'filament.pages.archived-sbmembers';
    protected static ?string $navigationGroup = 'Officials';
    protected static ?string $navigationLabel = 'Former SB Members';
    protected static ?int $navigationSort = 21;

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
                TextColumn::make('updated_at')
                    ->label('Marked Date')
                    ->dateTime('F d, Y h:i A')
                    ->sortable(),
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

                Tables\Actions\Action::make('delete')
                    ->label('Delete Permanently')
                    ->icon('heroicon-o-trash')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading('Delete SB Member Permanently')
                    ->modalDescription('Are you sure you want to permanently delete this SB member? This action cannot be undone.')
                    ->modalSubmitActionLabel('Delete')
                    ->action(function (Sbmember $record) {
                        $record->delete();

                        Notification::make()
                            ->title('SB Member Deleted')
                            ->body('The SB member has been permanently deleted.')
                            ->success()
                            ->send();
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkAction::make('restore')
                    ->label('Restore Selected')
                    ->icon('heroicon-o-arrow-uturn-left')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Restore Selected SB Members')
                    ->modalDescription('Are you sure you want to restore the selected SB members?')
                    ->modalSubmitActionLabel('Restore')
                    ->action(function (\Illuminate\Support\Collection $records, HasTable $livewire) {

                        foreach ($records as $record) {
                            $record->update([
                                'is_archived' => false,
                            ]);
                        }

                        // ✅ REFRESHER
                        $livewire->deselectAllTableRecords();

                        Notification::make()
                            ->title('SB Members Restored')
                            ->body('Selected SB members have been restored successfully.')
                            ->success()
                            ->send();
                    }),

                Tables\Actions\BulkAction::make('delete')
                    ->label('Delete Permanently')
                    ->icon('heroicon-o-trash')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading('Delete Selected SB Members')
                    ->modalDescription('This will permanently delete the selected SB members. This action cannot be undone.')
                    ->modalSubmitActionLabel('Delete')
                    ->action(function (\Illuminate\Support\Collection $records, HasTable $livewire) {

                        foreach ($records as $record) {
                            $record->delete();
                        }

                        // ✅ REFRESHER
                        $livewire->deselectAllTableRecords();

                        Notification::make()
                            ->title('SB Members Deleted')
                            ->body('Selected SB members have been permanently deleted.')
                            ->success()
                            ->send();
                    }),
            ]);
    }
}
