<?php

namespace App\Filament\Resources;

use App\Filament\Concerns\RequiresStaffAccess;
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
    use RequiresStaffAccess;

    protected static ?string $model = OfficialsImage::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';
    protected static ?string $navigationGroup = 'SB Members Details';
    protected static ?string $navigationLabel = 'Officials Image';
    protected static ?int $navigationSort = 12;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                FileUpload::make('image')
                    ->image()
                    ->directory('officials-images')
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
                    ->label('Officials')
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
                        \Filament\Infolists\Components\Section::make('Officials Preview')
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
            'index' => Pages\ListOfficialsImages::route('/'),
            'create' => Pages\CreateOfficialsImage::route('/create'),
            'edit' => Pages\EditOfficialsImage::route('/{record}/edit'),
        ];
    }
}
