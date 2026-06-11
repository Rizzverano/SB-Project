<?php

namespace App\Filament\Resources\AccomplishmentResource\Pages;

use App\Filament\Resources\AccomplishmentResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAccomplishment extends CreateRecord
{
    protected static string $resource = AccomplishmentResource::class;

    protected function getHeaderActions(): array
    {
        return
            [
                Actions\Action::make('back')
                    ->label('Back to List')
                    ->icon('heroicon-o-arrow-left')
                    ->color('gray')
                    ->url(AccomplishmentResource::getUrl('index')),
            ];
    }
}
