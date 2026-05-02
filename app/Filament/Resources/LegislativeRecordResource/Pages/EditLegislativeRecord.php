<?php

namespace App\Filament\Resources\LegislativeRecordResource\Pages;

use App\Filament\Resources\LegislativeRecordResource;
use Filament\Actions;
// use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;

class EditLegislativeRecord extends EditRecord
{
    protected static string $resource = LegislativeRecordResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->label('Archive')
                ->icon('heroicon-o-archive-box')
                ->color('warning')
                ->modalHeading('Archive Legislative Record')
                ->modalDescription('Are you sure you would like to archive this legislative record?')
                ->modalSubmitActionLabel('Archive')
                ->modalCancelActionLabel('Cancel')
                ->action(function ($record) {
                    $record->delete();
                    Notification::make()
                        ->title('Record Archived')
                        ->body('The legislative record has been archived successfully.')
                        ->success()
                        ->send();
                })
                ->after(function () {
                    // Redirect after the action is completed
                    $this->redirect(LegislativeRecordResource::getUrl('index'));
                }),
        ];
    }
}
