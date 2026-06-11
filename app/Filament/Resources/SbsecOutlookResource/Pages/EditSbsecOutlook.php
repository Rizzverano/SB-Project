<?php

namespace App\Filament\Resources\SbsecOutlookResource\Pages;

use App\Filament\Resources\SbsecOutlookResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSbsecOutlook extends EditRecord
{
    protected static string $resource = SbsecOutlookResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('back')
                ->label('Back to List')
                ->icon('heroicon-o-arrow-left')
                ->color('gray')
                ->url(SbsecOutlookResource::getUrl('index')),

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
