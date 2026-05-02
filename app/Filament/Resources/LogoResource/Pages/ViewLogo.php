<?php

namespace App\Filament\Resources\LogoResource\Pages;

use App\Filament\Resources\LogoResource;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;

class ViewLogo extends ViewRecord
{
    protected static string $resource = LogoResource::class;

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            Section::make('Logo set overview')
                ->description('Preview the uploaded logo assets and verify whether this set is the currently published version.')
                ->schema([
                    Grid::make(2)
                        ->schema([
                            ImageEntry::make('pres_gov')
                                ->label('Provincial government logo')
                                ->disk('public')
                                ->height(160),
                            ImageEntry::make('lgu_hilongos')
                                ->label('LGU Hilongos logo')
                                ->disk('public')
                                ->height(160),
                        ]),
                    Grid::make(2)
                        ->schema([
                            IconEntry::make('is_published')
                                ->label('Active published set')
                                ->boolean(),
                            TextEntry::make('created_at')
                                ->label('Created')
                                ->dateTime('F d, Y h:i A'),
                        ]),
                ])
                ->extraAttributes([
                    'class' => 'mx-auto max-w-5xl',
                ]),
        ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\EditAction::make(),
        ];
    }
}
