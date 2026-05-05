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
use Filament\Tables\Columns\IconColumn;
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
            ->columns([

                TextColumn::make('id')
                    ->label('#')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                ImageColumn::make('file')
                    ->label('Chart Preview')
                    ->disk('public')
                    ->defaultImageUrl(asset('images/default.jpg'))
                    ->height(80),

                IconColumn::make('is_publish')
                    ->label('Published')
                    ->boolean()
                    ->sortable(),

                TextColumn::make('created_at')
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
