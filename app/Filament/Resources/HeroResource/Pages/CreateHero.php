<?php

namespace App\Filament\Resources\HeroResource\Pages;

use App\Filament\Resources\HeroResource;
use App\Models\Hero;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateHero extends CreateRecord
{
    protected static string $resource = HeroResource::class;

    protected function getHeaderActions(): array
    {
        return
            [
                Actions\Action::make('back')
                    ->label('Back to List')
                    ->icon('heroicon-o-arrow-left')
                    ->color('gray')
                    ->url(HeroResource::getUrl('index')),
            ];
    }

    protected function afterCreate(): void
    {
        /** @var Hero $record */
        $record = $this->record;

        if ($record->is_publish) {
            $record->publishAsActive();
        }
    }
}
