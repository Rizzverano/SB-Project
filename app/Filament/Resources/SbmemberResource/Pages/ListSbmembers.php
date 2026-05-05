<?php

namespace App\Filament\Resources\SbmemberResource\Pages;

use App\Filament\Resources\SbmemberResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSbmembers extends ListRecords
{
    protected static string $resource = SbmemberResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('New SB Member')
                ->icon('heroicon-o-user-plus')
                ->color('primary'),
        ];
    }
}
