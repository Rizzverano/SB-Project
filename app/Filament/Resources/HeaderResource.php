<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HeaderResource\Pages;
use App\Models\Header;
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

class HeaderResource extends Resource
{
    protected static ?string $model = Header::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';

    protected static ?string $navigationGroup = 'Website Content';

    protected static ?string $navigationLabel = 'Headers';

    protected static ?int $navigationSort = 10;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Section::make('Header Image')
                ->description('Upload the header image displayed on the homepage.')
                ->schema([
                    FileUpload::make('image')
                        ->label('Header Image')
                        ->image()
                        ->imageEditor()
                        ->disk('public')
                        ->directory('headers')
                        ->required()
                        ->helperText('Recommended: high resolution banner image.')
                        ->columnSpanFull(),
                ]),

            Section::make('Publishing')
                ->schema([
                    Toggle::make('is_publish')
                        ->label('Set as active header')
                        ->helperText('Only one header should be active at a time.')
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
                    ->label('Header')
                    ->formatStateUsing(fn ($record) => 'Header #' . $record->id)
                    ->badge()
                    ->color('gray')
                    ->sortable(),

                ImageColumn::make('image')
                    ->label('Preview')
                    ->disk('public')
                    ->height(60),

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
                        \Filament\Infolists\Components\Section::make('Header Preview')
                            ->schema([
                                \Filament\Infolists\Components\ImageEntry::make('image')
                                    ->disk('public')
                                    ->height(200),

                                \Filament\Infolists\Components\IconEntry::make('is_publish')
                                    ->label('Active Header')
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
                    ->visible(fn (Header $record) => ! $record->is_publish)
                    ->requiresConfirmation()
                    ->modalHeading('Set Active Header')
                    ->modalDescription('This will make this header the active one and disable others.')
                    ->action(function (Header $record) {
                        Header::where('is_publish', true)
                            ->update(['is_publish' => false]);

                        $record->update(['is_publish' => true]);

                        Notification::make()
                            ->title('Header Updated')
                            ->body('This header is now active.')
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
            'index' => Pages\ListHeaders::route('/'),
            'create' => Pages\CreateHeader::route('/create'),
            'edit' => Pages\EditHeader::route('/{record}/edit'),
        ];
    }
}
