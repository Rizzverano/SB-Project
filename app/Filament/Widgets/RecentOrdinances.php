<?php

namespace App\Filament\Widgets;

use App\Models\Ordinance;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables\Columns\TextColumn;

class RecentOrdinances extends BaseWidget
{
    protected int|string|array $columnSpan = 'full';

    protected static ?int $sort = 3;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Ordinance::query()
                    ->where('is_archived', false)
                    ->latest()
                    ->limit(5)
            )
            ->heading('Recent Ordinances')
            ->columns([

                TextColumn::make('title')
                    ->searchable(),

                TextColumn::make('description')
                    ->searchable(),

                Tables\Columns\TextColumn::make('sponsor')
                    ->label('Sponsor')
                    ->searchable(),

                Tables\Columns\TextColumn::make('action')
                    ->label('Action Taken')
                    ->badge()
                    ->color(
                        fn($state) => match ($state) {
                            'Approved' => 'success',
                            'Marked as Noted' => 'gray',
                            'NONE' => 'secondary',
                            default => 'warning',
                        },
                    )
                    ->searchable(),

                TextColumn::make('publish_through')
                    ->searchable(),

                Tables\Columns\TextColumn::make('date')
                    ->label('Date Published')
                    ->formatStateUsing(function ($state) {
                        return $state
                            ? \Carbon\Carbon::parse($state)->format('M d, Y')
                            : 'No Date Published';
                    })
                    ->sortable(),

                TextColumn::make('file')
                    ->label('PDF')
                    ->formatStateUsing(fn ($state) => $state ? '📄 View PDF' : 'No File')
                    ->url(fn ($record) =>
                        $record->file ? asset('storage/' . $record->file) : null
                    )
                    ->openUrlInNewTab(),
            ])
            ->striped();
    }
}
