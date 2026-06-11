<?php

namespace App\Filament\Resources\AccomplishmentResource\Pages;

use App\Filament\Resources\AccomplishmentResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\EditRecord;

class EditAccomplishment extends EditRecord
{
    protected static string $resource = AccomplishmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('back')
                ->label('Back to List')
                ->icon('heroicon-o-arrow-left')
                ->color('gray')
                ->url(AccomplishmentResource::getUrl('index')),

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
