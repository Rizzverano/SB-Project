<?php

namespace App\Filament\Resources\OfficialsImageResource\Pages;

use App\Filament\Resources\OfficialsImageResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOfficialsImage extends EditRecord
{
    protected static string $resource = OfficialsImageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('back')
                ->label('Back to List')
                ->icon('heroicon-o-arrow-left')
                ->color('gray')
                ->url(OfficialsImageResource::getUrl('index')),

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
