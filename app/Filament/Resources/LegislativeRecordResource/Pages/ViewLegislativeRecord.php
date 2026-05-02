<?php

namespace App\Filament\Resources\LegislativeRecordResource\Pages;

use App\Filament\Resources\LegislativeRecordResource;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;

class ViewLegislativeRecord extends ViewRecord
{
    protected static string $resource = LegislativeRecordResource::class;

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            Section::make('Legislative record overview')
                ->description('Complete session context, authorship, and action status for this legislative entry.')
                ->schema([
                    Grid::make(2)
                        ->schema([
                            TextEntry::make('session')
                                ->label('Session')
                                ->badge()
                                ->color('info'),
                            TextEntry::make('date')
                                ->label('Session date')
                                ->date('F d, Y'),
                        ]),
                    TextEntry::make('title')
                        ->label('Title')
                        ->weight('bold')
                        ->size(TextEntry\TextEntrySize::Large)
                        ->columnSpanFull(),
                    TextEntry::make('description')
                        ->label('Description')
                        ->markdown()
                        ->placeholder('No description provided.')
                        ->prose()
                        ->columnSpanFull(),
                    Grid::make(2)
                        ->schema([
                            TextEntry::make('sponsor')
                                ->label('Sponsor')
                                ->placeholder('Not specified'),
                            TextEntry::make('action_taken')
                                ->label('Action taken')
                                ->badge()
                                ->color(
                                    fn ($state) => match ($state) {
                                        'Approved' => 'success',
                                        'Marked as Noted' => 'gray',
                                        'NONE' => 'secondary',
                                        default => 'warning',
                                    },
                                ),
                        ]),
                ])
                ->extraAttributes([
                    'class' => 'mx-auto max-w-5xl',
                ]),
        ]);
    }

    protected function getHeaderActions(): array
    {
        return [\Filament\Actions\EditAction::make()];
    }
}
