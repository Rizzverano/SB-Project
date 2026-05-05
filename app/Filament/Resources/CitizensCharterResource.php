<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CitizensCharterResource\Pages;
use App\Models\CitizensCharter;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CitizensCharterResource extends Resource
{
    protected static ?string $model = CitizensCharter::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Documents';
    protected static ?string $navigationLabel = 'Citizens Charter';
    protected static ?int $navigationSort = 14;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Citizens Charter Details')
                    ->description('Upload and manage the official Citizens Charter document.')
                    ->columns(2)
                    ->schema([

                        Forms\Components\FileUpload::make('file')
                            ->label('Upload PDF File')
                            ->disk('public')
                            ->directory('citizens-charter')
                            ->acceptedFileTypes(['application/pdf'])
                            ->rules(['required', 'mimes:pdf', 'max:10240'])
                            ->maxSize(10240) // 10MB
                            ->downloadable()
                            ->openable()
                            ->required()
                            ->columnSpan(2),

                        Forms\Components\Toggle::make('is_publish')
                            ->label('Publish this document')
                            ->helperText('Only published documents will be visible on the website.')
                            ->default(false)
                            ->onColor('success')
                            ->offColor('gray'),

                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                Tables\Columns\TextColumn::make('id')
                    ->label('#')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('file')
                    ->label('Document')
                    ->formatStateUsing(fn ($state) => $state ? '📄 View PDF' : 'No File')
                    ->url(fn ($record) => $record->file
                        ? asset('storage/' . $record->file)
                        : null)
                    ->openUrlInNewTab()
                    ->color('primary')
                    ->searchable(),

                Tables\Columns\IconColumn::make('is_publish')
                    ->label('Published')
                    ->boolean()
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Uploaded Date')
                    ->dateTime('F d, Y h:i A')
                    ->sortable(),

            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_publish')
                    ->label('Publication Status')
                    ->trueLabel('Published Only')
                    ->falseLabel('Unpublished Only')
                    ->placeholder('All'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListCitizensCharters::route('/'),
            'create' => Pages\CreateCitizensCharter::route('/create'),
            'edit'   => Pages\EditCitizensCharter::route('/{record}/edit'),
        ];
    }
}
