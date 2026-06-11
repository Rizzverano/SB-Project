<?php

namespace App\Filament\Resources\SbsecImageResource\Pages;

use App\Filament\Resources\SbsecImageResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSbsecImage extends EditRecord
{
    protected static string $resource = SbsecImageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('back')
                ->label('Back to List')
                ->icon('heroicon-o-arrow-left')
                ->color('gray')
                ->url(SbsecImageResource::getUrl('index')),

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
