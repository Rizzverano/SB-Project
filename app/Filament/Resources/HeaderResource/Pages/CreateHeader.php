<?php

namespace App\Filament\Resources\HeaderResource\Pages;

use App\Filament\Resources\HeaderResource;
use App\Models\Header;
use Filament\Resources\Pages\CreateRecord;

class CreateHeader extends CreateRecord
{
    protected static string $resource = HeaderResource::class;

    protected function afterCreate(): void
    {
        /** @var Header $record */
        $record = $this->record;

        if ($record->is_publish) {
            Header::where('is_publish', true)
                ->where('id', '!=', $record->id)
                ->update(['is_publish' => false]);
        }
    }
}
