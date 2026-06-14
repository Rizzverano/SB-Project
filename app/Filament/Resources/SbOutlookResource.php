<?php

namespace App\Filament\Resources;

use App\Filament\Concerns\RequiresStaffAccess;
use App\Filament\Resources\SbOutlookResource\Pages;
use App\Models\SbOutlook;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Tables\Table;

class SbOutlookResource extends Resource
{
    use RequiresStaffAccess;

    protected static ?string $model = SbOutlook::class;

    protected static ?string $navigationIcon = 'heroicon-o-light-bulb';
    protected static ?string $navigationGroup = 'SB Members Details';
    protected static ?string $navigationLabel = 'SB Outlooks';
    protected static ?int $navigationSort = 16;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('type')
                ->label('Outlook Types')
                ->placeholder('Either choose Challenges or Suggestions')
                ->options([
                    'Challenges' => 'Challenges',
                    'Suggestions' => 'Suggestions',
                ])
                ->required()
                ->native(false),

            Forms\Components\TextInput::make('title')
                ->placeholder('e.g; Funding Constraints or leave this field empty')
                ->maxLength(255),

            Forms\Components\Textarea::make('description')
                ->placeholder('Challenges e.g; Lack of Funding / Suggestions e.g; Codification of General Ordinances')
                ->required()
                ->rows(5)
                ->columnSpanFull(),

            Forms\Components\Section::make('Visibility')
                ->schema([
                    Forms\Components\Toggle::make('published')
                        ->label('Publish Outlook')
                        ->helperText('Enable to make this visible to users.')
                        ->default(false),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\BadgeColumn::make('type')
                    ->label('Outlook Type')
                    ->sortable(),

                Tables\Columns\TextColumn::make('title')
                    ->placeholder('No Title')
                    ->searchable(),

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
                    ->icon('heroicon-o-eye')
                    ->modal()
                    ->infolist([
                        \Filament\Infolists\Components\Section::make('SB Outlook Overview')
                            ->description('Review the details and publication status of this outlook.')
                            ->schema([
                                \Filament\Infolists\Components\TextEntry::make('type')
                                    ->badge(),

                                \Filament\Infolists\Components\TextEntry::make('title')
                                    ->placeholder('No Title')
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
            'index' => Pages\ListSbOutlooks::route('/'),
            'create' => Pages\CreateSbOutlook::route('/create'),
            'edit' => Pages\EditSbOutlook::route('/{record}/edit'),
        ];
    }
}
