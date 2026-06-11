<?php

namespace App\Filament\Resources\LegislativeRecordResource\Pages;

use App\Filament\Resources\LegislativeRecordResource;
use Filament\Actions;
// use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\TextEntry;

class EditLegislativeRecord extends EditRecord
{
    protected static string $resource = LegislativeRecordResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('back')
                ->label('Back to List')
                ->icon('heroicon-o-arrow-left')
                ->color('gray')
                ->url(LegislativeRecordResource::getUrl('index')),

            Actions\ViewAction::make()
                ->label('View')
                ->icon('heroicon-o-eye')
                ->color('info')
                ->modal()
                ->infolist([
                    Section::make('Legislative record overview')
                        ->description('Complete session context, authorship, and action status for this legislative entry.')
                        ->schema([
                            Grid::make(2)->schema([
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
                                ->columnSpanFull(),

                            TextEntry::make('description')
                                ->label('Description')
                                ->markdown()
                                ->placeholder('No description provided.')
                                ->prose()
                                ->columnSpanFull(),

                            Grid::make(2)->schema([
                                TextEntry::make('sponsor')
                                    ->label('Sponsor')
                                    ->placeholder('Not specified'),

                                TextEntry::make('action_taken')
                                    ->label('Action taken')
                                    ->badge()
                                    ->color(fn ($state) => match ($state) {
                                        'Approved' => 'success',
                                        'Marked as Noted' => 'gray',
                                        'NONE' => 'secondary',
                                        default => 'warning',
                                    }),
                            ]),
                        ]),
                ]),

            Actions\DeleteAction::make()
                ->label('Archive')
                ->icon('heroicon-o-archive-box')
                ->color('warning')
                ->modalHeading('Archive Legislative Record')
                ->modalDescription('Are you sure you would like to archive this legislative record?')
                ->modalSubmitActionLabel('Archive')
                ->modalCancelActionLabel('Cancel')
                ->action(function ($record) {
                    $record->delete();
                    Notification::make()
                        ->title('Record Archived')
                        ->body('The legislative record has been archived successfully.')
                        ->success()
                        ->send();
                })
                ->after(function () {
                    // Redirect after the action is completed
                    $this->redirect(LegislativeRecordResource::getUrl('index'));
                }),
        ];
    }
}
