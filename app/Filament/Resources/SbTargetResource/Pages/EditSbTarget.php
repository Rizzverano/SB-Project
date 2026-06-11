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
            Actions\Action::make('back')
                ->label('Back to List')
                ->icon('heroicon-o-arrow-left')
                ->color('gray')
                ->url(SbTargetResource::getUrl('index')),

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
