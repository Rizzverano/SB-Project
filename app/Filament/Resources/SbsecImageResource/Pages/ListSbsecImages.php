<?php

namespace App\Filament\Resources\SbsecImageResource\Pages;

use App\Filament\Resources\SbsecImageResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSbsecImages extends ListRecords
{
    protected static string $resource = SbsecImageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->icon('heroicon-o-photo'),
        ];
    }
}
