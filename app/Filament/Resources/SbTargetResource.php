<?php

namespace App\Filament\Resources;

use App\Filament\Concerns\RequiresStaffAccess;
use App\Filament\Resources\SbTargetResource\Pages;
use App\Models\SbTarget;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Tables\Table;

class SbTargetResource extends Resource
{
    use RequiresStaffAccess;

    protected static ?string $model = SbTarget::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-trending-up';
    protected static ?string $navigationGroup = 'SB Members Details';
    protected static ?string $navigationLabel = 'SB Targets';
    protected static ?int $navigationSort = 15;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('title')
                ->required()
                ->placeholder('e.g; SOCIAL PROTECTION')
                ->columnSpanFull()
                ->maxLength(255),

            Forms\Components\Textarea::make('description')
                ->required()
                ->placeholder('e.g; Ordinance Revising / Amending the Gender and Development Code of 2019')
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
                    ->icon('heroicon-o-eye')
                    ->modal()
                    ->infolist([
                        \Filament\Infolists\Components\Section::make('SB Target Overview')
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
            'index' => Pages\ListSbTargets::route('/'),
            'create' => Pages\CreateSbTarget::route('/create'),
            'edit' => Pages\EditSbTarget::route('/{record}/edit'),
        ];
    }
}
