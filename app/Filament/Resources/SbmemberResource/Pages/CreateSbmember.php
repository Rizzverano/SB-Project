<?php

namespace App\Filament\Resources\SbmemberResource\Pages;

use App\Filament\Resources\SbmemberResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateSbmember extends CreateRecord
{
    protected static string $resource = SbmemberResource::class;

    protected function getHeaderActions(): array
    {
        return
            [
                Actions\Action::make('back')
                    ->label('Back to List')
                    ->icon('heroicon-o-arrow-left')
                    ->color('gray')
                    ->url(SbmemberResource::getUrl('index')),
            ];
    }
}
