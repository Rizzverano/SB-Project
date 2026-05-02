<?php

namespace App\Filament\Resources\OrdinanceResource\Pages;

use App\Filament\Resources\OrdinanceResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListOrdinances extends ListRecords
{
    protected static string $resource = OrdinanceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->label('New ordinance')
            ->icon('heroicon-o-document-plus'),
        ];
    }
}
