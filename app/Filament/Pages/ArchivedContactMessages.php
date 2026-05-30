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
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\Grid;

class ArchivedContactMessages extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-archive-box';
    protected static string $view = 'filament.pages.archived-contact-messages';
    protected static ?string $navigationGroup = 'Admin Activities';
    protected static ?string $navigationLabel = 'Archived Contact Messages';
    protected static ?int $navigationSort = 16;

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
            ->columns([TextColumn::make('name')->searchable(), TextColumn::make('email')->searchable(), TextColumn::make('phone'), TextColumn::make('message')->limit(50)->tooltip(fn($state) => strlen($state) > 50 ? $state : null)->searchable(), TextColumn::make('is_read')->label('Status')->formatStateUsing(fn($state) => $state ? 'Read' : 'Unread')->badge()->color(fn($state) => $state ? 'success' : 'danger'), TextColumn::make('created_at')->label('Received At')->dateTime()->sortable()])
            ->striped()
            ->paginated([10, 25, 50])
            ->actions([
                Tables\Actions\Action::make('view')->label('View')->icon('heroicon-o-eye')->color('info')->modalHeading(fn(ContactMessage $record) => "Message from {$record->name}")->modalSubmitAction(false)->modalCancelActionLabel('Close')->infolist(
                    fn(Infolist $infolist, ContactMessage $record) => $infolist->record($record)->schema([
                        Section::make('Sender Details')->schema([Grid::make(2)->schema([TextEntry::make('name')->label('Name'), TextEntry::make('email')->label('Email')->icon('heroicon-o-envelope'), TextEntry::make('phone')->label('Phone')->icon('heroicon-o-phone')->placeholder('Not provided'), TextEntry::make('is_read')->label('Status')->formatStateUsing(fn($state) => $state ? 'Read' : 'Unread')->badge()->color(fn($state) => $state ? 'success' : 'danger')])]),

                        Section::make('Message')->schema([TextEntry::make('message')->label('')->prose()->columnSpanFull()]),

                        Section::make('Metadata')
                            ->schema([Grid::make(2)->schema([TextEntry::make('created_at')->label('Received At')->dateTime('F d, Y h:i A'), TextEntry::make('updated_at')->label('Last Updated')->dateTime('F d, Y h:i A')])])
                            ->collapsed(),
                    ]),
                ),

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

                        Notification::make()->title('Contact Message Restored')->body('The contact message has been restored successfully.')->success()->send();
                    }),

                Tables\Actions\Action::make('delete')
                    ->label('Delete Permanently')
                    ->icon('heroicon-o-trash')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading('Delete Contact Message Permanently')
                    ->modalDescription('Are you sure you want to permanently delete this message? This action cannot be undone.')
                    ->modalSubmitActionLabel('Delete Permanently')
                    ->action(function (ContactMessage $record) {
                        $record->delete();

                        Notification::make()->title('Contact Message Deleted')->body('The contact message has been permanently deleted.')->success()->send();
                    }),
            ])
            ->bulkActions([
                    Tables\Actions\BulkAction::make('restore')
                        ->label('Restore Selected')
                        ->icon('heroicon-o-arrow-uturn-left')
                        ->color('success')
                        ->requiresConfirmation()
                        ->modalHeading('Restore Selected Messages')
                        ->modalDescription('Are you sure you want to restore the selected contact messages?')
                        ->modalSubmitActionLabel('Restore')
                        ->action(function (\Illuminate\Support\Collection $records, HasTable $livewire) {

                        foreach ($records as $record) {
                            $record->update(['is_archived' => false]);
                        }

                        // ✅ REFRESHER (THIS IS WHAT YOU NEED)
                        $livewire->deselectAllTableRecords();

                            Notification::make()->title('Contact Messages Restored')->body('Selected contact messages have been restored successfully.')->success()->send();
                        }),

                    Tables\Actions\BulkAction::make('delete')
                        ->label('Delete Permanently')
                        ->icon('heroicon-o-trash')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->modalHeading('Delete Selected Messages Permanently')
                        ->modalDescription('Are you sure you want to permanently delete the selected messages? This action cannot be undone.')
                        ->modalSubmitActionLabel('Delete Permanently')
                        ->action(function (\Illuminate\Support\Collection $records, HasTable $livewire) {

                        foreach ($records as $record) {
                            $record->delete();
                        }

                        // ✅ REFRESHER (CLEAR SELECTION)
                        $livewire->deselectAllTableRecords();

                            Notification::make()->title('Contact Messages Deleted')->body('Selected contact messages have been permanently deleted.')->success()->send();
                        }),
            ]);
    }
}
