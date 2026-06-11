<?php

namespace App\Filament\Resources\OfficialsImageResource\Pages;

use App\Filament\Resources\OfficialsImageResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateOfficialsImage extends CreateRecord
{
    protected static string $resource = OfficialsImageResource::class;

    protected function getHeaderActions(): array
    {
        return
            [
                Actions\Action::make('back')
                    ->label('Back to List')
                    ->icon('heroicon-o-arrow-left')
                    ->color('gray')
                    ->url(OfficialsImageResource::getUrl('index')),
            ];
    }
}
