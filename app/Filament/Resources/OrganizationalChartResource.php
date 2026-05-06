<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrganizationalChartResource\Pages;
use App\Models\OrganizationalChart;
use Filament\Resources\Resource;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Tables\Columns\TextColumn;

class OrganizationalChartResource extends Resource
{
    protected static ?string $model = OrganizationalChart::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Documents';
    protected static ?string $navigationLabel = 'Organizational Chart';
    protected static ?int $navigationSort = 15;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Organizational Chart Details')
                    ->description('Upload and manage the organizational chart image.')
                    ->columns(2)
                    ->schema([

                        Forms\Components\TextInput::make('title')
                            ->label('Chart Title')
                            ->placeholder('Enter chart title')
                            ->required()
                            ->maxLength(255)
                            ->columnSpan(2),

                        FileUpload::make('file')
                            ->label('Upload Chart Image')
                            ->image()
                            ->disk('public')
                            ->directory('organizational-charts')
                            ->imagePreviewHeight('200')
                            ->required()
                            ->columnSpan(2),

                        Toggle::make('is_publish')
                            ->label('Publish this image')
                            ->helperText('Only published charts will be visible on the website.')
                            ->default(false)
                            ->onColor('success')
                            ->offColor('gray'),

                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(static::getEloquentQuery()->where('is_archived', false))
            ->columns([

                TextColumn::make('title')
                    ->label('Title')
                    ->searchable()
                    ->sortable(),

                ImageColumn::make('file')
                    ->label('Chart Preview')
                    ->disk('public')
                    ->defaultImageUrl(asset('images/default.jpg'))
                    ->height(80),

                CheckboxColumn::make('is_publish')
                    ->label('Published')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('created_at')
                    ->label('Uploaded Date')
                    ->dateTime('F d, Y h:i A')
                    ->sortable(),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('archive')
                    ->label('Archive')
                    ->icon('heroicon-o-archive-box')
                    ->color('warning')
                    ->requiresConfirmation()
                    ->modalHeading('Archive Organizational Chart')
                    ->modalDescription('Are you sure you want to archive this organizational chart?')
                    ->action(function ($record) {
                        $record->update([
                            'is_archived' => true,
                        ]);

                        Notification::make()
                            ->title('Organizational Chart Archived')
                            ->body('Organizational chart has been successfully archived.')
                            ->success()
                            ->send();
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkAction::make('archive')
                    ->label('Archive Selected')
                    ->icon('heroicon-o-archive-box')
                    ->color('warning')
                    ->requiresConfirmation()
                    ->action(function ($records) {
                        $records->each->update(['is_archived' => true]);

                        Notification::make()
                            ->title('Organizational Charts Archived')
                            ->body('Selected organizational charts have been successfully archived.')
                            ->success()
                            ->send();
                    }),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrganizationalCharts::route('/'),
            'create' => Pages\CreateOrganizationalChart::route('/create'),
            'edit' => Pages\EditOrganizationalChart::route('/{record}/edit'),
        ];
    }
}
