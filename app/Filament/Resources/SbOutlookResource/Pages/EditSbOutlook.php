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
            Actions\Action::make('back')
                ->label('Back to List')
                ->icon('heroicon-o-arrow-left')
                ->color('gray')
                ->url(SbOutlookResource::getUrl('index')),

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
