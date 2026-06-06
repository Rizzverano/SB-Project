<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SbsecImageResource\Pages;
use App\Models\SbsecImage;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

// Form Components
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Toggle;

// Table Columns
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Tables\Columns\ImageColumn;

class SbsecImageResource extends Resource
{
    protected static ?string $model = SbsecImage::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';
    protected static ?string $navigationGroup = 'SB Secretary Office Details';
    protected static ?string $navigationLabel = 'SB Secretary Office Image';
    protected static ?int $navigationSort = 9;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                FileUpload::make('image')
                    ->image()
                    ->directory('sbsec-images')
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
                    ->label('SB Secretary Office')
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
            'index' => Pages\ListSbsecImages::route('/'),
            'create' => Pages\CreateSbsecImage::route('/create'),
            'edit' => Pages\EditSbsecImage::route('/{record}/edit'),
        ];
    }
}
