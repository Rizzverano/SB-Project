<?php

namespace App\Filament\Resources;

use App\Filament\Concerns\RequiresStaffAccess;
use App\Filament\Resources\SbsecTargetResource\Pages;
use App\Models\SbsecTarget;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Tables\Table;

class SbsecTargetResource extends Resource
{
    use RequiresStaffAccess;

    protected static ?string $model = SbsecTarget::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-trending-up';
    protected static ?string $navigationGroup = 'SB Secretariat Details';
    protected static ?string $navigationLabel = 'SBSEC Targets';
    protected static ?int $navigationSort = 18;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('title')
                ->required()
                ->columnSpanFull()
                ->maxLength(255),

            Forms\Components\Textarea::make('description')
                ->required()
                ->rows(5)
                ->columnSpanFull(),

            Forms\Components\Section::make('Visibility')
                ->schema([
                    Forms\Components\Toggle::make('published')
                        ->label('Publish Target')
                        ->helperText('Enable to make this visible to users.')
                        ->default(false),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('description')
                    ->limit(80)
                    ->wrap(),

                CheckboxColumn::make('published')
                    ->label('Published')
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Created'),
            ])
            ->defaultSort('created_at', 'desc')
            ->striped()
            ->paginated([10, 25, 50])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->color('info')
                    ->modal()
                    ->infolist([
                        \Filament\Infolists\Components\Section::make('SBSEC Target Overview')
                            ->description('Review the details and publication status of this target.')
                            ->schema([
                                \Filament\Infolists\Components\TextEntry::make('title')
                                    ->weight('bold')
                                    ->columnSpanFull(),

                                \Filament\Infolists\Components\TextEntry::make('description')
                                    ->prose()
                                    ->columnSpanFull(),

                                \Filament\Infolists\Components\Grid::make(2)
                                    ->schema([
                                        \Filament\Infolists\Components\IconEntry::make('published')
                                            ->label('Published')
                                            ->boolean(),

                                        \Filament\Infolists\Components\TextEntry::make('created_at')
                                            ->label('Created')
                                            ->dateTime('F d, Y h:i A'),
                                    ]),
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
            'index' => Pages\ListSbsecTargets::route('/'),
            'create' => Pages\CreateSbsecTarget::route('/create'),
            'edit' => Pages\EditSbsecTarget::route('/{record}/edit'),
        ];
    }
}
