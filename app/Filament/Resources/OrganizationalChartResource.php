<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrganizationalChartResource\Pages;
use App\Models\OrganizationalChart;
use Filament\Resources\Resource;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Toggle;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\Grid;

class OrganizationalChartResource extends Resource
{
    protected static ?string $model = OrganizationalChart::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Documents';
    protected static ?string $navigationLabel = 'Organizational Chart';
    protected static ?int $navigationSort = 13;

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
            ->query(static::getEloquentQuery())
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
            ->striped()
            ->paginated([10, 25, 50])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('view')
                    ->label('View')
                    ->icon('heroicon-o-eye')
                    ->color('info')
                    ->modalHeading(fn (OrganizationalChart $record) => $record->title)
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Close')
                    ->infolist(fn (Infolist $infolist, OrganizationalChart $record) => $infolist
                        ->record($record)
                        ->schema([
                            Section::make('Chart Preview')
                                ->icon('heroicon-o-photo')
                                ->schema([
                                    ImageEntry::make('file')
                                        ->label('')
                                        ->disk('public')
                                        ->defaultImageUrl(asset('images/default.jpg'))
                                        ->height(400)
                                        ->extraImgAttributes(['class' => 'object-contain w-full mx-auto'])
                                        ->columnSpanFull(),
                                ]),

                            Section::make('Chart Details')
                                ->icon('heroicon-o-information-circle')
                                ->schema([
                                    Grid::make(3)
                                        ->schema([
                                            TextEntry::make('title')
                                                ->label('Chart Title')
                                                ->weight('bold'),

                                            IconEntry::make('is_publish')
                                                ->label('Published')
                                                ->boolean(),

                                            TextEntry::make('created_at')
                                                ->label('Uploaded Date')
                                                ->dateTime('F d, Y h:i A'),
                                        ]),
                                ])
                                ->collapsed(),
                        ])
                    ),

                Tables\Actions\EditAction::make(),

                Tables\Actions\DeleteAction::make()
                    ->label('Delete')
                    ->icon('heroicon-o-trash')
                    ->color('danger')
                    ->requiresConfirmation(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()
                    ->label('Delete Selected')
                    ->icon('heroicon-o-trash')
                    ->color('danger')
                    ->requiresConfirmation(),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListOrganizationalCharts::route('/'),
            'create' => Pages\CreateOrganizationalChart::route('/create'),
            'edit'   => Pages\EditOrganizationalChart::route('/{record}/edit'),
        ];
    }
}
