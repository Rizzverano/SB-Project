<?php

namespace App\Filament\Widgets;

use App\Filament\Pages\ViewLegislativeRecord;
use App\Models\LegislativeRecord;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentLegislativeRecords extends BaseWidget
{
    protected int|string|array $columnSpan = 'full';

    protected static ?int $sort = 2;

    public function table(Table $table): Table
    {
        return $table
            ->query(LegislativeRecord::query())
            ->columns([
                Tables\Columns\TextColumn::make('session')->searchable(),

                Tables\Columns\TextColumn::make('date')->date('F j, Y')->sortable(),

                Tables\Columns\TextColumn::make('title')
                    ->formatStateUsing(
                        fn($record) => "
                    <strong>{$record->title}</strong><br>
                    <small>{$record->description}</small>
                ",
                    )
                    ->html()
                    ->wrap()
                    ->searchable(),

                Tables\Columns\TextColumn::make('sponsor')
                    ->label('Sponsor')
                    ->wrap(),

                Tables\Columns\TextColumn::make('action_taken')->badge()->color(
                    fn(string $state): string => match ($state) {
                        'Approved' => 'success',
                        'Marked as Noted' => 'gray',
                        'NONE' => 'secondary',
                        default => 'warning',
                    },
                ),
            ])
            ->defaultSort('date', 'desc')
            ->striped()
            ->paginated([10, 25, 50])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->url(fn (LegislativeRecord $record): string => ViewLegislativeRecord::getUrl([
                        'record' => $record,
                    ])),
            ])
            ->heading('Recent Legislative Records');
    }
}
