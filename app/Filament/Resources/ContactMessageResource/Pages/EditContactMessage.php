<?php

namespace App\Filament\Resources\ContactMessageResource\Pages;

use App\Filament\Resources\ContactMessageResource;
use App\Models\ContactMessage;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditContactMessage extends EditRecord
{
    protected static string $resource = ContactMessageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('archive')
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
        ];
    }
}
