<?php

namespace App\Filament\Resources\SbmemberResource\Pages;

use App\Filament\Resources\SbmemberResource;
use App\Models\Sbmember;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditSbmember extends EditRecord
{
    protected static string $resource = SbmemberResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('back')
                ->label('Back to List')
                ->icon('heroicon-o-arrow-left')
                ->color('gray')
                ->url(SbmemberResource::getUrl('index')),

            Actions\ViewAction::make()
                ->label('View')
                ->icon('heroicon-o-eye')
                ->color('info'),

            Actions\Action::make('archive')
                ->label('Mark as Former')
                ->icon('heroicon-o-user-group')
                ->color('warning')
                ->requiresConfirmation()
                ->modalHeading('Mark SB Member as Former')
                ->modalDescription('Are you sure you want to mark this SB member as former?')
                ->modalSubmitActionLabel('Mark as Former')
                ->action(function (Sbmember $record) {
                    $record->update([
                        'is_archived' => true,
                        'is_publish' => false,
                    ]);

                    Notification::make()
                        ->title('SB Member Marked as Former')
                        ->body('The SB member has been marked as former successfully.')
                        ->success()
                        ->send();
                }),
        ];
    }
}
