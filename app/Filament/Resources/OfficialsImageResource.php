<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OfficialsImageResource\Pages;
use App\Models\OfficialsImage;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Table;


class OfficialsImageResource extends Resource
{
    protected static ?string $model = OfficialsImage::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';
    protected static ?string $navigationGroup = 'SB Members Details';
    protected static ?string $navigationLabel = 'Officials Image';
    protected static ?int $navigationSort = 9;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                FileUpload::make('image')
                    ->image()
                    ->directory('officials-images')
                    ->required(),

                Section::make('Visibility')
                    ->schema([
                        Toggle::make('published')
                            ->label('Publish')
                            ->helperText('Enable to make this visible to users.')
                            ->default(false),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->label('Officials')
                    ->disk('public')
                    ->square()
                    ->size(72),

                CheckboxColumn::make('published')
                    ->label('Published')
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('published')
                    ->label('Published Status'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOfficialsImages::route('/'),
            'create' => Pages\CreateOfficialsImage::route('/create'),
            'edit' => Pages\EditOfficialsImage::route('/{record}/edit'),
        ];
    }
}
