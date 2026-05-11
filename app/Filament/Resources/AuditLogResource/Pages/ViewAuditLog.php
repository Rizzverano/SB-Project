<?php

namespace App\Filament\Resources\AuditLogResource\Pages;

use App\Filament\Resources\AuditLogResource;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;

class ViewAuditLog extends ViewRecord
{
    protected static string $resource = AuditLogResource::class;

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Login Attempt')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('email')->label('Email'),
                                TextEntry::make('status')->badge(),
                                TextEntry::make('ip_address')->label('IP Address'),
                                TextEntry::make('attempted_at')->label('Attempted At')->dateTime(),
                                TextEntry::make('failure_reason')->label('Failure Reason')->placeholder('-'),
                                IconEntry::make('is_locked')->label('Locked')->boolean(),
                                IconEntry::make('has_challenge')->label('Challenge')->boolean(),
                            ]),
                        TextEntry::make('user_agent')
                            ->label('User Agent')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
