<?php


namespace App\Filament\Resources\LegislativeRecordResource\Pages;

use App\Filament\Resources\LegislativeRecordResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateLegislativeRecord extends CreateRecord
{
    protected static string $resource = LegislativeRecordResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('back')
                ->label('Back to List')
                ->icon('heroicon-o-arrow-left')
                ->color('gray')
                ->url(LegislativeRecordResource::getUrl('index')),
        ];
    }
}

