<?php

namespace App\Filament\Resources\SbsecImageResource\Pages;

use App\Filament\Resources\SbsecImageResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSbsecImage extends EditRecord
{
    protected static string $resource = SbsecImageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
