<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\Ordinance;
use Filament\Tables;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Table;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Notifications\Notification;

class ArchivedOrdinances extends Page implements HasTable
{
    use InteractsWithTable;

    public bool $accessGranted = false;

    public ?string $archivePassword = null;

    protected static ?string $navigationIcon = 'heroicon-o-archive-box';
    protected static string $view = 'filament.pages.archived-ordinances';
    protected static ?int $navigationSort = 4;
    protected static ?string $navigationGroup = 'Ordinance';
    protected static ?string $navigationLabel = 'Archived Ordinances';

    public function mount(): void
    {
        $this->accessGranted = session()->get('ordinance_archive_access', false);
    }

    public function verifyPassword(): void
    {
        $correctPassword = env('ARCHIVE_ORDINANCE_PASSWORD');

        if ($this->archivePassword !== $correctPassword) {

            Notification::make()
                ->title('Invalid Password')
                ->danger()
                ->send();

            return;
        }

        session()->put('ordinance_archive_access', true);

        $this->accessGranted = true;

        Notification::make()
            ->title('Access Granted')
            ->success()
            ->send();
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                    $this->accessGranted
                        ? Ordinance::query()->where('is_archived', true)
                        : Ordinance::query()->whereRaw('1 = 0')
                    )
            ->columns([

                TextColumn::make('title')
                    ->searchable(),

                TextColumn::make('description')
                    ->searchable(),

                Tables\Columns\TextColumn::make('sponsor')
                    ->label('Sponsor')
                    ->searchable(),

                Tables\Columns\TextColumn::make('action')
                    ->label('Action taken'),

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

                CheckboxColumn::make('not_applicable')
                    ->label('Not Applicable')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('file')
                    ->label('PDF')
                    ->formatStateUsing(fn ($state) => $state ? '📄 View PDF' : 'No File')
                    ->url(fn ($record) =>
                        $record->file ? asset('storage/' . $record->file) : null
                    )
                    ->openUrlInNewTab(),

                CheckboxColumn::make('published')
                    ->label('Published')
                    ->sortable()
                    ->toggleable(),
            ])
            ->striped()
            ->paginated([10, 25, 50])
            ->filters([
                        Tables\Filters\SelectFilter::make('sponsor')
                ->label('Filter by Sponsor')
                ->options(
                    \App\Models\Ordinance::where('is_archived', false)
                        ->whereNotNull('sponsor')
                        ->distinct()
                        ->orderBy('sponsor')
                        ->pluck('sponsor', 'sponsor')
                        ->toArray()
                )
                ->searchable()
                ->preload(),

            Tables\Filters\SelectFilter::make('publish_through')
                ->label('Filter by Publish Through')
                ->options(
                    \App\Models\Ordinance::where('is_archived', false)
                        ->whereNotNull('publish_through')
                        ->distinct()
                        ->orderBy('publish_through')
                        ->pluck('publish_through', 'publish_through')
                        ->toArray()
                )
                ->searchable()
                ->preload(),
            ])
            ->filtersLayout(Tables\Enums\FiltersLayout::AboveContent)
            ->actions([

                Tables\Actions\Action::make('preview')
                    ->label('Preview')
                    ->icon('heroicon-o-eye')
                    ->modalHeading('PDF Preview')
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Close')
                    ->modalContent(function ($record) {
                        $url = asset('storage/' . $record->file);

                        return view('filament.preview.pdf', compact('url'));
                    }),

                Tables\Actions\Action::make('restore')
                    ->label('Restore')
                    ->icon('heroicon-o-arrow-uturn-left')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Restore Ordinance')
                    ->modalDescription('Are you sure you would like to restore this ordinance?')
                    ->modalSubmitActionLabel('Restore')
                    ->action(function ($record) {
                        $record->update([
                            'is_archived' => false,
                        ]);

                        Notification::make()
                            ->title('Ordinance Restored')
                            ->body('The ordinance has been restored successfully.')
                            ->success()
                            ->send();
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkAction::make('bulk_restore')
                    ->label('Bulk Restore')
                    ->icon('heroicon-o-arrow-uturn-left')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Restore Selected Ordinances')
                    ->modalDescription('Are you sure you want to restore the selected ordinances?')
                    ->modalSubmitActionLabel('Restore All')
                    ->action(function (\Illuminate\Support\Collection $records, HasTable $livewire) {

                        foreach ($records as $record) {
                            $record->update([
                                'is_archived' => false,
                            ]);
                        }

                        // ✅ CLEAR SELECTION (your requested refresher)
                        $livewire->deselectAllTableRecords();

                        Notification::make()
                            ->title('Selected Ordinances Restored')
                            ->body('All selected ordinances have been restored successfully.')
                            ->success()
                            ->send();
                    }),
            ]);
    }
}
