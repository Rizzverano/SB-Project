<?php

namespace App\Filament\Resources\HeaderResource\Pages;

use App\Filament\Resources\HeaderResource;
use App\Models\Header;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateHeader extends CreateRecord
{
    protected static string $resource = HeaderResource::class;

    protected function getHeaderActions(): array
    {
        return
            [
                Actions\Action::make('back')
                    ->label('Back to List')
                    ->icon('heroicon-o-arrow-left')
                    ->color('gray')
                    ->url(HeaderResource::getUrl('index')),
            ];
    }

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
