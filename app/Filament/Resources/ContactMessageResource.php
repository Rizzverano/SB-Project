<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactMessageResource\Pages;
use App\Models\ContactMessage;
use Filament\Forms\Form;
use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

use Filament\Tables\Columns\TextColumn;

class ContactMessageResource extends Resource
{
    protected static ?string $model = ContactMessage::class;

    protected static ?string $navigationIcon = 'heroicon-o-envelope';

    protected static ?string $navigationLabel = 'Contact Messages';

    protected static ?string $navigationGroup = 'Admin Activities';

    protected static ?int $navigationSort = 16;

    /**
     * ✅ Filament 4 SAFE: only control entry access here
     */
    public static function canViewAny(): bool
    {
        $user = auth()->user();

        return $user && method_exists($user, 'isAdmin') && $user->isAdmin();
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')
                ->required()
                ->maxLength(255),

            Forms\Components\TextInput::make('email')
                ->email()
                ->required()
                ->maxLength(255),

            Forms\Components\TextInput::make('phone')
                ->maxLength(20),

            Forms\Components\Textarea::make('message')
                ->required()
                ->columnSpanFull(),

            Forms\Components\Toggle::make('is_read')
                ->label('Mark as Read')
                ->visibleOn('edit'),

            Forms\Components\TextInput::make('is_read')
                ->label('Status')
                ->disabled()
                ->formatStateUsing(fn ($state) => $state ? 'Read' : 'Unread')
                ->visibleOn('view'),
        ]);
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query
                ->where('is_archived', false)
                ->latest())
            ->columns([
                TextColumn::make('name')->searchable(),
                TextColumn::make('email')->searchable(),
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
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('toggleRead')
                    ->label(fn ($record) => $record->is_read ? 'Mark as Unread' : 'Mark as Read')
                    ->action(fn (ContactMessage $record) => $record->update(['is_read' => ! $record->is_read]))
                    ->icon('heroicon-o-check'),
                Tables\Actions\Action::make('archive')
                    ->label('Archive')
                    ->icon('heroicon-o-archive-box')
                    ->color('warning')
                    ->requiresConfirmation()
                    ->modalHeading('Archive Contact Message')
                    ->modalDescription('Are you sure you want to archive this contact message?')
                    ->modalSubmitActionLabel('Archive')
                    ->action(function (ContactMessage $record) {
                        $record->update([
                            'is_archived' => true,
                        ]);

                        Notification::make()
                            ->title('Contact Message Archived')
                            ->body('The contact message has been archived successfully.')
                            ->success()
                            ->send();
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkAction::make('archive')
                    ->label('Archive Selected')
                    ->icon('heroicon-o-archive-box')
                    ->color('warning')
                    ->requiresConfirmation()
                    ->modalHeading('Archive Contact Messages')
                    ->modalDescription('Are you sure you want to archive the selected contact messages?')
                    ->modalSubmitActionLabel('Archive')
                    ->action(function ($records) {
                        $records->each->update([
                            'is_archived' => true,
                        ]);

                        Notification::make()
                            ->title('Contact Messages Archived')
                            ->body('Selected contact messages have been archived successfully.')
                            ->success()
                            ->send();
                    }),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListContactMessages::route('/'),
            'create' => Pages\CreateContactMessage::route('/create'),
            'edit' => Pages\EditContactMessage::route('/{record}/edit'),
        ];
    }
}
