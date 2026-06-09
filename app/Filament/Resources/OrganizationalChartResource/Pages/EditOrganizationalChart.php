<?php

namespace App\Filament\Resources\OrganizationalChartResource\Pages;

use App\Filament\Resources\OrganizationalChartResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOrganizationalChart extends EditRecord
{
    protected static string $resource = OrganizationalChartResource::class;

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
