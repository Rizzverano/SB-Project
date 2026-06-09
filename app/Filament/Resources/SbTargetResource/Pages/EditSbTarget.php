<?php

namespace App\Filament\Resources\SbTargetResource\Pages;

use App\Filament\Resources\SbTargetResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSbTarget extends EditRecord
{
    protected static string $resource = SbTargetResource::class;

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
