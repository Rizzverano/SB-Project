<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HeroResource\Pages;
use App\Models\Hero;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;

class HeroResource extends Resource
{
    protected static ?string $model = Hero::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';

    protected static ?string $navigationGroup = 'Website Content';

    protected static ?string $navigationLabel = 'Hero Sections';

    protected static ?int $navigationSort = 11;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Section::make('Hero Images')
                ->description('Upload the hero images displayed on the homepage banner.')
                ->schema([
                    FileUpload::make('image1')
                        ->label('Hero Image 1')
                        ->image()
                        ->imageEditor()
                        ->disk('public')
                        ->directory('heroes')
                        ->required()
                        ->helperText('Primary hero image.'),

                    FileUpload::make('image2')
                        ->label('Hero Image 2')
                        ->image()
                        ->imageEditor()
                        ->disk('public')
                        ->directory('heroes')
                        ->required()
                        ->helperText('Secondary hero image.'),
                ])
                ->columns(2),

            Section::make('Publishing')
                ->schema([
                    Toggle::make('is_publish')
                        ->label('Set as active hero')
                        ->helperText('Only one hero section should be active at a time.')
                        ->default(false),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->latest())
            ->columns([
                TextColumn::make('id')
                    ->label('Hero')
                    ->formatStateUsing(fn ($record) => 'Hero #' . $record->id)
                    ->badge()
                    ->color('gray')
                    ->sortable(),

                ImageColumn::make('image1')
                    ->label('Image 1')
                    ->disk('public')
                    ->size(70),

                ImageColumn::make('image2')
                    ->label('Image 2')
                    ->disk('public')
                    ->size(70),

                IconColumn::make('is_publish')
                    ->label('Active')
                    ->boolean()
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime('M d, Y h:i A')
                    ->sortable(),
            ])
            ->striped()
            ->paginated([10, 25, 50])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->modal()
                    ->infolist([
                        \Filament\Infolists\Components\Section::make('Hero Preview')
                            ->schema([
                                \Filament\Infolists\Components\Grid::make(2)
                                    ->schema([
                                        \Filament\Infolists\Components\ImageEntry::make('image1')
                                            ->disk('public')
                                            ->height(180),

                                        \Filament\Infolists\Components\ImageEntry::make('image2')
                                            ->disk('public')
                                            ->height(180),
                                    ]),

                                \Filament\Infolists\Components\IconEntry::make('is_publish')
                                    ->label('Active Hero')
                                    ->boolean(),

                                \Filament\Infolists\Components\TextEntry::make('created_at')
                                    ->label('Created')
                                    ->dateTime('F d, Y h:i A'),
                            ]),
                    ]),

                Tables\Actions\EditAction::make(),

                Tables\Actions\Action::make('publish')
                    ->label('Set Active')
                    ->icon('heroicon-o-check-badge')
                    ->color('success')
                    ->visible(fn (Hero $record) => ! $record->is_publish)
                    ->requiresConfirmation()
                    ->modalHeading('Set Active Hero')
                    ->modalDescription('This will make this hero the active one and disable others.')
                    ->action(function (Hero $record) {
                        Hero::where('is_publish', true)
                            ->update(['is_publish' => false]);

                        $record->update(['is_publish' => true]);

                        Notification::make()
                            ->title('Hero Updated')
                            ->body('This hero section is now active.')
                            ->success()
                            ->send();
                    }),

                Tables\Actions\DeleteAction::make()
                    ->color('danger')
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
            'index' => Pages\ListHeroes::route('/'),
            'create' => Pages\CreateHero::route('/create'),
            'edit' => Pages\EditHero::route('/{record}/edit'),
        ];
    }
}
