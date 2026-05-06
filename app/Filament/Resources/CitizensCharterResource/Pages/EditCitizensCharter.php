<?php

namespace App\Filament\Resources\CitizensCharterResource\Pages;

use App\Filament\Resources\CitizensCharterResource;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditCitizensCharter extends EditRecord
{
    protected static string $resource = CitizensCharterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('archive')
                ->label('Archive')
                ->icon('heroicon-o-archive-box')
                ->color('warning')
                ->requiresConfirmation()
                ->modalHeading('Archive Citizens Charter')
                ->modalDescription('Are you sure you want to archive this citizens charter?')
                ->action(function ($record) {
                    $record->update([
                        'is_archived' => true,
                    ]);

                    Notification::make()
                        ->title('Citizens Charter Archived')
                        ->success()
                        ->send();
                }),
        ];
    }
}
