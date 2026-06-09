<?php

namespace App\Filament\Resources\SbOutlookResource\Pages;

use App\Filament\Resources\SbOutlookResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSbOutlook extends EditRecord
{
    protected static string $resource = SbOutlookResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make()
                ->label('View')
                ->icon('heroicon-o-eye')
                ->color('info'),

            Actions\DeleteAction::make()
                ->label('Delete')
                ->icon('heroicon-o-trash')
                ->color('danger')
                ->requiresConfirmation(),
        ];
    }
}
