<?php

namespace App\Filament\Resources\SbsecOutlookResource\Pages;

use App\Filament\Resources\SbsecOutlookResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateSbsecOutlook extends CreateRecord
{
    protected static string $resource = SbsecOutlookResource::class;

    protected function getHeaderActions(): array
    {
        return
            [
                Actions\Action::make('back')
                    ->label('Back to List')
                    ->icon('heroicon-o-arrow-left')
                    ->color('gray')
                    ->url(SbsecOutlookResource::getUrl('index')),
            ];
    }
}
