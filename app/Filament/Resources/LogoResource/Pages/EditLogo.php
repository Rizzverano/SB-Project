<?php

namespace App\Filament\Resources\LogoResource\Pages;

use App\Filament\Resources\LogoResource;
use App\Models\Logo;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditLogo extends EditRecord
{
    protected static string $resource = LogoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\Action::make('archive')
                ->label('Archive')
                ->icon('heroicon-o-archive-box')
                ->color('warning')
                ->requiresConfirmation()
                ->modalHeading('Archive Logo Set')
                ->modalDescription('Are you sure you want to archive this logo set?')
                ->modalSubmitActionLabel('Archive')
                ->action(function (Logo $record) {
                    $record->update([
                        'is_archived' => true,
                        'is_published' => false,
                    ]);

                    Notification::make()
                        ->title('Logo Set Archived')
                        ->body('The logo set has been archived successfully.')
                        ->success()
                        ->send();
                }),
        ];
    }

    protected function afterSave(): void
    {
        /** @var Logo $record */
        $record = $this->record;

        if ($record->is_published) {
            $record->publishAsActive();
        }
    }
}
