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
            Actions\DeleteAction::make(),
        ];
    }
}
