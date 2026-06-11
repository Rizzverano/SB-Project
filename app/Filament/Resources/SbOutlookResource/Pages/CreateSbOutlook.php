<?php

namespace App\Filament\Resources\SbOutlookResource\Pages;

use App\Filament\Resources\SbOutlookResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateSbOutlook extends CreateRecord
{
    protected static string $resource = SbOutlookResource::class;

    protected function getHeaderActions(): array
    {
        return
        [
            Actions\Action::make('back')
                ->label('Back to List')
                ->icon('heroicon-o-arrow-left')
                ->color('gray')
                ->url(SbOutlookResource::getUrl('index')),
        ];
    }
}
