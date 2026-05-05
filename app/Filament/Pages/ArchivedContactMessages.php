<?php

namespace App\Filament\Pages;

use App\Models\ContactMessage;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;

class ArchivedContactMessages extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-archive-box';
    protected static string $view = 'filament.pages.archived-contact-messages';
    protected static ?string $navigationGroup = 'Admin Activities';
    protected static ?string $navigationLabel = 'Archived Contact Messages';
    protected static ?int $navigationSort = 17;

    public static function canAccess(): bool
    {
        $user = auth()->user();

        return $user && method_exists($user, 'isAdmin') && $user->isAdmin();
    }

    public static function shouldRegisterNavigation(): bool
    {
        return static::canAccess();
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(ContactMessage::query()->where('is_archived', true)->latest())
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('email')
                    ->searchable(),
                TextColumn::make('phone'),
                TextColumn::make('message')
                    ->limit(50)
                    ->tooltip(fn ($state) => strlen($state) > 50 ? $state : null),
                TextColumn::make('is_read')
                    ->label('Status')
                    ->formatStateUsing(fn ($state) => $state ? 'Read' : 'Unread')
                    ->badge()
                    ->color(fn ($state) => $state ? 'success' : 'danger'),
                TextColumn::make('created_at')
                    ->label('Received At')
                    ->dateTime()
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\Action::make('restore')
                    ->label('Restore')
                    ->icon('heroicon-o-arrow-uturn-left')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Restore Contact Message')
                    ->modalDescription('Are you sure you would like to restore this contact message?')
                    ->modalSubmitActionLabel('Restore')
                    ->action(function (ContactMessage $record) {
                        $record->update([
                            'is_archived' => false,
                        ]);

                        Notification::make()
                            ->title('Contact Message Restored')
                            ->body('The contact message has been restored successfully.')
                            ->success()
                            ->send();
                    }),
            ]);
    }
}
