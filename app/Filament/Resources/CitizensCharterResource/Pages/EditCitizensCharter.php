<?php

namespace App\Filament\Resources\CitizensCharterResource\Pages;

use App\Filament\Resources\CitizensCharterResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCitizensCharter extends EditRecord
{
    protected static string $resource = CitizensCharterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('back')
                ->label('Back to List')
                ->icon('heroicon-o-arrow-left')
                ->color('gray')
                ->url(CitizensCharterResource::getUrl('index')),

            Actions\DeleteAction::make()
                ->label('Delete')
                ->icon('heroicon-o-trash')
                ->color('danger')
                ->requiresConfirmation(),
        ];
    }
}
