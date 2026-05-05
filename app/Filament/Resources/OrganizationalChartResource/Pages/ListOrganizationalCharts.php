<?php

namespace App\Filament\Resources\OrganizationalChartResource\Pages;

use App\Filament\Resources\OrganizationalChartResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListOrganizationalCharts extends ListRecords
{
    protected static string $resource = OrganizationalChartResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('New Organizational Chart')
                ->icon('heroicon-o-document-plus'),
        ];
    }
}
