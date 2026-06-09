<?php

namespace App\Filament\Resources;

use App\Filament\Concerns\RequiresStaffAccess;
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
    use RequiresStaffAccess;

    protected static ?string $model = SbsecImage::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';
    protected static ?string $navigationGroup = 'SB Secretariat Details';
    protected static ?string $navigationLabel = 'SB Secretary Office Image';
    protected static ?int $navigationSort = 17;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                FileUpload::make('image')
                    ->image()
                    ->directory('sbsec-images')
                    ->columnSpanFull()
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
            ->defaultSort('created_at', 'desc')
            ->striped()
            ->paginated([10, 25, 50])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label('View')
                    ->icon('heroicon-o-eye')
                    ->color('info')
                    ->modal()
                    ->infolist([
                        \Filament\Infolists\Components\Section::make('SB Secretary Office Preview')
                            ->schema([
                                \Filament\Infolists\Components\ImageEntry::make('image')
                                    ->disk('public')
                                    ->height(250),

                                \Filament\Infolists\Components\IconEntry::make('published')
                                    ->label('Published')
                                    ->boolean(),

                                \Filament\Infolists\Components\TextEntry::make('created_at')
                                    ->label('Created')
                                    ->dateTime('F d, Y h:i A'),
                            ]),
                    ]),

                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->requiresConfirmation(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()
                    ->requiresConfirmation(),
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
