<?php

namespace App\Filament\Resources\SbsecOutlookResource\Pages;

use App\Filament\Resources\SbsecOutlookResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSbsecOutlooks extends ListRecords
{
    protected static string $resource = SbsecOutlookResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('New Outlook')
                ->icon('heroicon-o-plus'),
        ];
    }
}
