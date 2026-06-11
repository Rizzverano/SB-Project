<?php

namespace App\Filament\Resources\SbsecImageResource\Pages;

use App\Filament\Resources\SbsecImageResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateSbsecImage extends CreateRecord
{
    protected static string $resource = SbsecImageResource::class;

    protected function getHeaderActions(): array
    {
        return
            [
                Actions\Action::make('back')
                    ->label('Back to List')
                    ->icon('heroicon-o-arrow-left')
                    ->color('gray')
                    ->url(SbsecImageResource::getUrl('index')),
            ];
    }
}
