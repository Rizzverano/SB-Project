<?php

namespace App\Filament\Resources\CitizensCharterResource\Pages;

use App\Filament\Resources\CitizensCharterResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCitizensCharter extends CreateRecord
{
    protected static string $resource = CitizensCharterResource::class;

    protected function getHeaderActions(): array
    {
        return
            [
                Actions\Action::make('back')
                    ->label('Back to List')
                    ->icon('heroicon-o-arrow-left')
                    ->color('gray')
                    ->url(CitizensCharterResource::getUrl('index')),
            ];
    }
}
