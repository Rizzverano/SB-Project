<?php

namespace App\Filament\Resources\SbTargetResource\Pages;

use App\Filament\Resources\SbTargetResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateSbTarget extends CreateRecord
{
    protected static string $resource = SbTargetResource::class;

    protected function getHeaderActions(): array
    {
        return
            [
                Actions\Action::make('back')
                    ->label('Back to List')
                    ->icon('heroicon-o-arrow-left')
                    ->color('gray')
                    ->url(SbTargetResource::getUrl('index')),
            ];
    }
}
