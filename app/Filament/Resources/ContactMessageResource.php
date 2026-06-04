<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactMessageResource\Pages;
use App\Mail\ContactMessageReadMail;
use App\Models\ContactMessage;
use Filament\Forms\Form;
use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\TextColumn;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\Grid;
use Illuminate\Support\Facades\Mail;
use Filament\Tables\Contracts\HasTable;
use Throwable;

class ContactMessageResource extends Resource
{
    protected static ?string $model = ContactMessage::class;

    protected static ?string $navigationIcon = 'heroicon-o-envelope';

    protected static ?string $navigationLabel = 'Contact Messages';

    protected static ?string $navigationGroup = 'Admin Activities';

    protected static ?int $navigationSort = 16;

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
                ->where('is_spam', false)
                ->latest())
            ->columns([
                TextColumn::make('name')->searchable(),
                TextColumn::make('email')->searchable(),
                TextColumn::make('phone'),
                TextColumn::make('message')
                    ->limit(50)
                    ->tooltip(fn ($state) => strlen($state) > 50 ? $state : null)
                    ->searchable(),
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
            ->striped()
            ->paginated([10, 25, 50])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('view')
                    ->label('View')
                    ->icon('heroicon-o-eye')
                    ->color('info')
                    ->modalHeading(fn (ContactMessage $record) => "Message from {$record->name}")
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Close')
                    ->infolist(fn (Infolist $infolist, ContactMessage $record) => $infolist
                        ->record($record)
                        ->schema([
                            Section::make('Sender Details')
                                ->icon('heroicon-o-user')
                                ->schema([
                                    Grid::make(3)
                                        ->schema([
                                            TextEntry::make('name')
                                                ->label('Full Name'),

                                            TextEntry::make('email')
                                                ->label('Email Address')
                                                ->icon('heroicon-o-envelope'),

                                            TextEntry::make('phone')
                                                ->label('Phone Number')
                                                ->icon('heroicon-o-phone')
                                                ->placeholder('Not provided'),
                                        ]),
                                ]),

                            Section::make('Message')
                                ->icon('heroicon-o-chat-bubble-left-ellipsis')
                                ->schema([
                                    TextEntry::make('message')
                                        ->label('')
                                        ->prose()
                                        ->columnSpanFull(),
                                ]),

                            Section::make('Received')
                                ->icon('heroicon-o-clock')
                                ->schema([
                                    TextEntry::make('created_at')
                                        ->label('Received At')
                                        ->dateTime('F d, Y h:i A'),
                                ])
                                ->collapsed(),
                        ])
                    ),

                Tables\Actions\Action::make('toggleRead')
                    ->label('Mark as Read')
                    ->icon('heroicon-o-check')
                    ->color('primary')
                    ->visible(fn ($record) => ! $record->is_read)
                    ->action(function (ContactMessage $record) {
                        $record->update(['is_read' => true]);

                        try {
                            Mail::to($record->email)->send(new ContactMessageReadMail($record));

                            Notification::make()
                                ->title('Marked as Read')
                                ->body('An email notification was sent to the sender.')
                                ->success()
                                ->send();
                        } catch (Throwable $exception) {
                            report($exception);

                            Notification::make()
                                ->title('Marked as Read')
                                ->body('The message was marked as read, but the email could not be sent.')
                                ->warning()
                                ->send();
                        }
                    }),

                Tables\Actions\Action::make('markSpam')
                    ->label('Mark as Spam')
                    ->icon('heroicon-o-shield-exclamation')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading('Mark as Spam')
                    ->modalDescription('Are you sure you want to move this message to spam?')
                    ->modalSubmitActionLabel('Yes, mark as spam')
                    ->action(function (ContactMessage $record) {
                        $record->update([
                            'is_spam' => true,
                        ]);

                        Notification::make()
                            ->title('Marked as Spam')
                            ->body('The message has been moved to spam successfully.')
                            ->success()
                            ->send();
                    }),

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
                        ->action(function ($records, HasTable $livewire) {

                        $records->each->update([
                            'is_archived' => true
                        ]);

                        // ✅ CLEAR SELECTION (IMPORTANT)
                        $livewire->deselectAllTableRecords();

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
            'index'  => Pages\ListContactMessages::route('/'),
            'create' => Pages\CreateContactMessage::route('/create'),
        ];
    }
}
