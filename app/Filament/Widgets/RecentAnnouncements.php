<?php

namespace App\Filament\Widgets;

use App\Models\Announcement;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentAnnouncements extends BaseWidget
{
    protected int|string|array $columnSpan = 'full';

    protected static ?int $sort = 4;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Announcement::query()
                    ->where('is_archived', false)
                    ->where('published', true)
                    ->latest()
                    ->limit(5)
            )
            ->heading('Recent Announcements')
            ->columns([
                TextColumn::make('title')
                    ->label('Announcement')
                    ->formatStateUsing(
                        fn (Announcement $record) => "
                            <strong>{$record->title}</strong><br>
                            <small>{$record->description}</small>
                        "
                    )
                    ->html()
                    ->wrap()
                    ->searchable(),
            ])
            ->striped();
    }
}
