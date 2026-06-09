<?php

namespace App\Filament\Resources\SbsecTargetResource\Pages;

use App\Filament\Resources\SbsecTargetResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSbsecTargets extends ListRecords
{
    protected static string $resource = SbsecTargetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('New Target')
                ->icon('heroicon-o-plus'),
        ];
    }
}
