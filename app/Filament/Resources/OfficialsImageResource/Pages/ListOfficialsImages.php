<?php

namespace App\Filament\Resources\OfficialsImageResource\Pages;

use App\Filament\Resources\OfficialsImageResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListOfficialsImages extends ListRecords
{
    protected static string $resource = OfficialsImageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->icon('heroicon-o-photo'),
        ];
    }
}
