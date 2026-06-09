<?php

namespace App\Filament\Resources\SbOutlookResource\Pages;

use App\Filament\Resources\SbOutlookResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSbOutlooks extends ListRecords
{
    protected static string $resource = SbOutlookResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('New Outlook')
                ->icon('heroicon-o-plus'),
        ];
    }
}
