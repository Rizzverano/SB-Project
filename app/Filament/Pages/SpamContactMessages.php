<?php

namespace App\Filament\Pages;

use App\Models\BlockedEmail;
use App\Models\BlockedIp;
use App\Models\ContactMessage;
use Filament\Pages\Page;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\BulkAction;
use Illuminate\Support\Collection;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\TextEntry;

class SpamContactMessages extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $navigationLabel = 'Spam Messages';
    protected static ?string $navigationGroup = 'Admin Activities';
    protected static ?string $navigationIcon = 'heroicon-o-shield-exclamation';
    protected static ?int $navigationSort = 27;

    protected static string $view = 'filament.pages.spam-contact-messages';

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
            ->query(
                ContactMessage::query()
                    ->where('is_spam', true)
                    ->where('is_archived', false)
                    ->latest()
            )
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable(),
                Tables\Columns\TextColumn::make('email')->searchable(),
                Tables\Columns\TextColumn::make('message')
                    ->limit(50)
                    ->tooltip(fn ($state) => strlen($state) > 50 ? $state : null),
                Tables\Columns\TextColumn::make('ip_address')
                    ->label('IP Address'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->label('Received At'),
            ])

            ->actions([
                Tables\Actions\Action::make('view')
                    ->label('View')
                    ->icon('heroicon-o-eye')
                    ->color('info')
                    ->modalHeading(fn (ContactMessage $record) => "Message from {$record->name}")
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Close')
                    ->infolist(function (Infolist $infolist, ContactMessage $record) {
                        return $infolist
                            ->record($record)
                            ->schema([

                                Section::make('Sender Details')
                                    ->icon('heroicon-o-user')
                                    ->schema([
                                        Grid::make(3)->schema([
                                            TextEntry::make('name')->label('Full Name'),

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
                            ]);
                    }),

                // 🚫 BLOCK
                Tables\Actions\Action::make('blockSender')
                    ->label('Block Sender')
                    ->icon('heroicon-o-no-symbol')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading('Block Sender')
                    ->modalDescription('Block email and device permanently?')
                    ->visible(function (ContactMessage $record) {
                        return ! (
                            \App\Models\BlockedEmail::where('email', $record->email)->exists() ||
                            (
                                ! empty($record->ip_address) &&
                                \App\Models\BlockedIp::where('ip_address', $record->ip_address)->exists()
                            )
                        );
                    })
                    ->action(function (ContactMessage $record) {

                        BlockedEmail::firstOrCreate([
                            'email' => $record->email,
                        ]);

                        if (! empty($record->ip_address)) {
                            BlockedIp::firstOrCreate([
                                'ip_address' => $record->ip_address,
                            ]);
                        }

                        Notification::make()
                            ->title('Blocked Successfully')
                            ->body('Email and device are now blocked.')
                            ->success()
                            ->send();
                    }),

                // ✅ NOT SPAM
                Tables\Actions\Action::make('markNotSpam')
                    ->label('Mark as Not Spam')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn ($record) => $record->is_spam)
                    ->modalHeading('Mark as Not Spam')
                    ->modalDescription('Are you sure you want to move this message out of spam?')
                    ->modalSubmitActionLabel('Yes, mark as not spam')
                    ->action(function (ContactMessage $record) {

                        $record->update([
                            'is_spam' => false,
                        ]);

                        Notification::make()
                            ->title('Message Restored')
                            ->body('The message has been moved out of spam successfully.')
                            ->success()
                            ->send();
                    }),

                Tables\Actions\Action::make('archive')
                    ->label('Archive')
                    ->icon('heroicon-o-archive-box')
                    ->color('warning')
                    ->requiresConfirmation()
                    ->modalHeading('Archive Message')
                    ->modalDescription('Move this message to archive?')
                    ->action(function (ContactMessage $record) {

                        $record->update([
                            'is_archived' => true,
                        ]);

                        Notification::make()
                            ->title('Archived')
                            ->body('The message has been archived.')
                            ->success()
                            ->send();
                    }),
            ])

            ->bulkActions([
                BulkAction::make('markNotSpamSelected')
                    ->label('Mark Selected as Not Spam')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Mark Selected as Not Spam')
                    ->modalDescription('Are you sure you want to move the selected messages out of spam?')
                    ->modalSubmitActionLabel('Yes, mark as not spam')
                    ->action(function (Collection $records, $livewire) {

                        foreach ($records as $record) {
                            $record->update(['is_spam' => false]);
                        }

                        // ✅ clear selection
                        $livewire->deselectAllTableRecords();

                        Notification::make()
                            ->title('Messages Restored')
                            ->body('Selected messages have been moved out of spam.')
                            ->success()
                            ->send();
                    }),

                Tables\Actions\BulkAction::make('archive')
                    ->label('Archive Selected')
                    ->icon('heroicon-o-archive-box')
                    ->color('warning')
                    ->requiresConfirmation()
                    ->modalHeading('Archive Selected Messages')
                    ->modalDescription('Are you sure you want to archive the selected messages?')
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
            ]);
    }
}
