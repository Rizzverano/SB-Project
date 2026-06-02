<?php

namespace App\Filament\Resources\ArchivedAuditLogResource\Pages;

use App\Filament\Resources\ArchivedAuditLogResource;
use Filament\Resources\Pages\ListRecords;

class ListArchivedAuditLogs extends ListRecords
{
    protected static string $resource = ArchivedAuditLogResource::class;
}
