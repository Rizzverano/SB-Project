<?php

namespace App\Filament\Resources\SbsecTargetResource\Pages;

use App\Filament\Resources\SbsecTargetResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateSbsecTarget extends CreateRecord
{
    protected static string $resource = SbsecTargetResource::class;

    protected function getHeaderActions(): array
    {
        return
            [
                Actions\Action::make('back')
                    ->label('Back to List')
                    ->icon('heroicon-o-arrow-left')
                    ->color('gray')
                    ->url(SbsecTargetResource::getUrl('index')),
            ];
    }
}
