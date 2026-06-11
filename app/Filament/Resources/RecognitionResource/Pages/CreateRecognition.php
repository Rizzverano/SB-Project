<?php

namespace App\Filament\Resources\RecognitionResource\Pages;

use App\Filament\Resources\RecognitionResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateRecognition extends CreateRecord
{
    protected static string $resource = RecognitionResource::class;

    protected function getHeaderActions(): array
    {
        return
            [
                Actions\Action::make('back')
                    ->label('Back to List')
                    ->icon('heroicon-o-arrow-left')
                    ->color('gray')
                    ->url(RecognitionResource::getUrl('index')),
            ];
    }
}
