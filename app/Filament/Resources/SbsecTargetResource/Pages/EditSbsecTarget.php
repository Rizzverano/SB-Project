<?php

namespace App\Filament\Resources\SbsecTargetResource\Pages;

use App\Filament\Resources\SbsecTargetResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSbsecTarget extends EditRecord
{
    protected static string $resource = SbsecTargetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('back')
                ->label('Back to List')
                ->icon('heroicon-o-arrow-left')
                ->color('gray')
                ->url(SbsecTargetResource::getUrl('index')),

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
