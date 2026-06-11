<?php

namespace App\Filament\Resources\OrdinanceResource\Pages;

use App\Filament\Resources\OrdinanceResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateOrdinance extends CreateRecord
{
    protected static string $resource = OrdinanceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('back')
                ->label('Back to List')
                ->icon('heroicon-o-arrow-left')
                ->color('gray')
                ->url(OrdinanceResource::getUrl('index')),
        ];
    }
}
