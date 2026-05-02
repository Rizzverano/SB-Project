<?php

namespace App\Filament\Resources\OrdinanceResource\Pages;

use App\Filament\Resources\OrdinanceResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditOrdinance extends EditRecord
{
    protected static string $resource = OrdinanceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('archive')
                ->label('Archive')
                ->icon('heroicon-o-archive-box')
                ->color('warning')
                ->requiresConfirmation()
                ->modalHeading('Archive Ordinance')
                ->modalDescription('Are you sure you would like to archive this ordinance?')
                ->modalSubmitActionLabel('Archive')
                ->modalCancelActionLabel('Cancel')
                ->action(function ($record) {
                    $record->update([
                        'is_archived' => true,
                    ]);

                    Notification::make()->title('Ordinance Archived')->body('The ordinance has been archived successfully.')->success()->send();
                })
                ->after(function () {
                    $this->redirect(OrdinanceResource::getUrl('index'));
                }),
        ];
    }
}
