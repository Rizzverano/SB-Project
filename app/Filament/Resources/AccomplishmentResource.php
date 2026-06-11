<?php

namespace App\Filament\Resources;

use App\Filament\Concerns\RequiresStaffAccess;
use App\Filament\Resources\AccomplishmentResource\Pages;
use App\Models\Accomplishment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Tables\Table;

class AccomplishmentResource extends Resource
{
    use RequiresStaffAccess;

    protected static ?string $model = Accomplishment::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?string $navigationGroup = 'SB Members Details';
    protected static ?string $navigationLabel = 'Major Accomplishments';
    protected static ?int $navigationSort = 13;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('committee_name')
                ->required()
                ->maxLength(255),

            Forms\Components\TextInput::make('ord_no')
                ->required()
                ->maxLength(255),

            Forms\Components\TextInput::make('ord_title')
                ->required()
                ->columnSpanFull()
                ->maxLength(255),

            Forms\Components\Section::make('Visibility')
                ->schema([
                    Forms\Components\Toggle::make('published')
                        ->label('Publish Accomplishment')
                        ->helperText('Enable to make this visible to users.')
                        ->default(false),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('committee_name')
                    ->searchable(),

                Tables\Columns\TextColumn::make('ord_no')
                    ->searchable(),

                Tables\Columns\TextColumn::make('ord_title')
                    ->searchable()
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
                        \Filament\Infolists\Components\Section::make('Accomplishment Overview')
                            ->description('Review the details and publication status of this accomplishment.')
                            ->schema([
                                \Filament\Infolists\Components\TextEntry::make('committee_name')
                                    ->label('Committee')
                                    ->weight('bold')
                                    ->columnSpanFull(),

                                \Filament\Infolists\Components\TextEntry::make('ord_no')
                                    ->label('Ordinance No.')
                                    ->columnSpanFull(),

                                \Filament\Infolists\Components\TextEntry::make('ord_title')
                                    ->label('Title')
                                    ->columnSpanFull()
                                    ->prose(),

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
            'index' => Pages\ListAccomplishments::route('/'),
            'create' => Pages\CreateAccomplishment::route('/create'),
            'edit' => Pages\EditAccomplishment::route('/{record}/edit'),
        ];
    }
}
