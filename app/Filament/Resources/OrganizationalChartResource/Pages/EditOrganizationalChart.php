<?php

namespace App\Filament\Resources\OrganizationalChartResource\Pages;

use App\Filament\Resources\OrganizationalChartResource;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditOrganizationalChart extends EditRecord
{
    protected static string $resource = OrganizationalChartResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('archive')
                ->label('Archive')
                ->icon('heroicon-o-archive-box')
                ->color('warning')
                ->requiresConfirmation()
                ->modalHeading('Archive Organizational Chart')
                ->modalDescription('Are you sure you want to archive this organizational chart?')
                ->action(function ($record) {
                    $record->update([
                        'is_archived' => true,
                    ]);

                    Notification::make()
                        ->title('Organizational Chart Archived')
                        ->success()
                        ->send();
                }),
        ];
    }
}
