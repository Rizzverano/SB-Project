<?php

namespace App\Filament\Resources;

use App\Filament\Concerns\RequiresStaffAccess;
use App\Filament\Resources\RecognitionResource\Pages;
use App\Models\Recognition;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Tables\Table;

class RecognitionResource extends Resource
{
    use RequiresStaffAccess;

    protected static ?string $model = Recognition::class;

    protected static ?string $navigationIcon = 'heroicon-o-trophy';
    protected static ?string $navigationGroup = 'SB Members Details';
    protected static ?string $navigationLabel = 'Recognitions';
    protected static ?int $navigationSort = 14;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('award')
                ->label('Award Type')
                ->required()
                ->placeholder('e.g; 3RD RUNNER UP (1st-3rd Class Municipalities)')
                ->maxLength(255),

            Forms\Components\TextInput::make('category')
                ->label('Recognition Description')
                ->required()
                ->placeholder('e.g; 2023 Local Legislative Award Regional Onsite Validation')
                ->maxLength(255),

            Forms\Components\Section::make('Visibility')
                ->schema([
                    Forms\Components\Toggle::make('published')
                        ->label('Publish Recognition')
                        ->helperText('Enable to make this visible to users.')
                        ->default(false),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('award')
                    ->label('Award Type')
                    ->searchable(),

                Tables\Columns\TextColumn::make('category')
                    ->label('Recognition Description')
                    ->searchable(),

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
                        \Filament\Infolists\Components\Section::make('Recognition Overview')
                            ->description('Review the details and publication status of this recognition.')
                            ->schema([
                                \Filament\Infolists\Components\TextEntry::make('award')
                                    ->label('Award')
                                    ->weight('bold')
                                    ->columnSpanFull(),

                                \Filament\Infolists\Components\TextEntry::make('category')
                                    ->label('Category')
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
            'index' => Pages\ListRecognitions::route('/'),
            'create' => Pages\CreateRecognition::route('/create'),
            'edit' => Pages\EditRecognition::route('/{record}/edit'),
        ];
    }
}
