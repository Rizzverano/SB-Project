<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CitizensCharterResource\Pages;
use App\Models\CitizensCharter;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\CheckboxColumn;

class CitizensCharterResource extends Resource
{
    protected static ?string $model = CitizensCharter::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Documents';
    protected static ?string $navigationLabel = 'Citizens Charter';
    protected static ?int $navigationSort = 12;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Citizens Charter Details')
                    ->description('Upload and manage the official Citizens Charter document. PDF Upload Only.')
                    ->columns(2)
                    ->schema([

                        Forms\Components\TextInput::make('title')
                            ->label('Document Title')
                            ->placeholder('Enter document title')
                            ->required()
                            ->maxLength(255)
                            ->columnSpan(2),

                        Forms\Components\FileUpload::make('file')
                            ->label('Upload PDF')
                            ->disk('public')
                            ->directory('citizens-charter')
                            ->acceptedFileTypes(['application/pdf'])
                            ->rules(['required', 'mimes:pdf', 'max:307200'])
                            ->maxSize(307200) // 300MB
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
            ->query(static::getEloquentQuery())
            ->columns([

                Tables\Columns\TextColumn::make('title')
                    ->label('Title')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('file')
                    ->label('Document')
                    ->formatStateUsing(fn ($state) => $state ? '📄View PDF' : 'No File')
                    ->url(fn ($record) => $record->file
                        ? asset('storage/' . $record->file)
                        : null)
                    ->openUrlInNewTab()
                    ->color('primary'),

                CheckboxColumn::make('is_publish')
                    ->label('Published')
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('created_at')
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

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListCitizensCharters::route('/'),
            'create' => Pages\CreateCitizensCharter::route('/create'),
            'edit'   => Pages\EditCitizensCharter::route('/{record}/edit'),
        ];
    }
}
