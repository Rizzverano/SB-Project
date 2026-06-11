<?php

namespace App\Filament\Resources\OrganizationalChartResource\Pages;

use App\Filament\Resources\OrganizationalChartResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateOrganizationalChart extends CreateRecord
{
    protected static string $resource = OrganizationalChartResource::class;

    protected function getHeaderActions(): array
    {
        return
        [
            Actions\Action::make('back')
                ->label('Back to List')
                ->icon('heroicon-o-arrow-left')
                ->color('gray')
                ->url(OrganizationalChartResource::getUrl('index')),
        ];
    }
}
