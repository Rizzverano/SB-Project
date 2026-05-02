<?php

namespace App\Filament\Resources\AnnouncementResource\Pages;

use App\Filament\Resources\AnnouncementResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;

class EditAnnouncement extends EditRecord
{
    protected static string $resource = AnnouncementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('archive')
                    ->label('Archive')
                    ->icon('heroicon-o-archive-box')
                    ->color('warning')
                    ->requiresConfirmation()
                    ->modalHeading('Archive Announcement')
                    ->modalDescription('Are you sure you want to archive this announcement?')
                    ->action(function ($record) {
                        $record->update([
                            'is_archived' => true,
                        ]);

                        Notification::make()
                            ->title('Announcement Archived')
                            ->success()
                            ->send();
                    }),
        ];
    }
}
