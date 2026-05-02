<?php

namespace App\Filament\Resources\AnnouncementResource\Pages;

use App\Filament\Resources\AnnouncementResource;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;

class ViewAnnouncement extends ViewRecord
{
    protected static string $resource = AnnouncementResource::class;

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            Section::make('Announcement overview')
                ->description('Review the content, visibility status, and publishing timestamp for this announcement.')
                ->schema([
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
                            IconEntry::make('published')
                                ->label('Published')
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
