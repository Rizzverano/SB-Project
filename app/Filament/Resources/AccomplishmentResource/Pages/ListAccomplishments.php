<?php

namespace App\Filament\Resources\AccomplishmentResource\Pages;

use App\Filament\Resources\AccomplishmentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAccomplishments extends ListRecords
{
    protected static string $resource = AccomplishmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('New Accomplishment')
                ->icon('heroicon-o-plus'),
        ];
    }
}
