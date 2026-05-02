<?php

namespace App\Filament\Resources\LogoResource\Pages;

use App\Filament\Resources\LogoResource;
use App\Models\Logo;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLogo extends EditRecord
{
    protected static string $resource = LogoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        /** @var Logo $record */
        $record = $this->record;

        if ($record->is_published) {
            $record->publishAsActive();
        }
    }
}
