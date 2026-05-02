<?php

namespace App\Filament\Resources\LogoResource\Pages;

use App\Filament\Resources\LogoResource;
use App\Models\Logo;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateLogo extends CreateRecord
{
    protected static string $resource = LogoResource::class;

    protected function afterCreate(): void
    {
        /** @var Logo $record */
        $record = $this->record;

        if ($record->is_published) {
            $record->publishAsActive();
        }
    }
}
