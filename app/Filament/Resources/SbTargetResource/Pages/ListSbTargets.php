<?php

namespace App\Filament\Resources\SbTargetResource\Pages;

use App\Filament\Resources\SbTargetResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSbTargets extends ListRecords
{
    protected static string $resource = SbTargetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('New Target')
                ->icon('heroicon-o-plus'),
        ];
    }
}
