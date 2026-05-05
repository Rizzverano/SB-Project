<?php

namespace App\Filament\Resources\CitizensCharterResource\Pages;

use App\Filament\Resources\CitizensCharterResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCitizensCharters extends ListRecords
{
    protected static string $resource = CitizensCharterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('New Citizens Charter')
                ->icon('heroicon-o-document-plus'),
        ];
    }
}
