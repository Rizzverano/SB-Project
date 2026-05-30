<?php

namespace App\Filament\Resources;

use App\Enums\Permission;
use App\Models\User;
use App\Filament\Resources\LogoResource\Pages;
use App\Models\Logo;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class LogoResource extends Resource
{
    protected static ?string $model = Logo::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';

    protected static ?string $navigationGroup = 'Gov Logos';

    protected static ?string $navigationLabel = 'Logo Sets';

    protected static ?int $navigationSort = 9;

    protected static function hasPermission(Permission $permission): bool
    {
        $user = auth()->user();
        if (!$user) return false;

        $permissions = match ($user->role) {
            User::ADMIN => Permission::adminPermissions(),
            User::MEMBER => Permission::memberPermissions(),
            default => [],
        };

        $permissionValues = array_map(fn($p) => $p->value, $permissions);
        return in_array($permission->value, $permissionValues, true);
    }

    public static function canViewAny(): bool
    {
        return self::hasPermission(Permission::LOGO_SETS);
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Section::make('Logo files')
                ->description('Upload the official logo set used across the admin panel and related pages.')
                ->schema([
                    FileUpload::make('pres_gov')
                        ->label('National government logo')
                        ->image()
                        ->imageEditor()
                        ->disk('public')
                        ->directory('logos')
                        ->required()
                        ->helperText('Recommended: square image with transparent background.')
                        ->columnSpan(1),
                    FileUpload::make('lgu_hilongos')
                        ->label('LGU Hilongos logo')
                        ->image()
                        ->imageEditor()
                        ->disk('public')
                        ->directory('logos')
                        ->required()
                        ->helperText('Use the official LGU seal or approved visual mark.')
                        ->columnSpan(1),
                ])
                ->columns(2),
            Section::make('Publishing')
                ->schema([
                    Toggle::make('is_published')
                        ->label('Set as active logo set')
                        ->helperText('When enabled, this logo set becomes the active published set.')
                        ->default(false),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table->modifyQueryUsing(fn (Builder $query) => $query
            ->latest())
            ->columns([
                TextColumn::make('id')
                    ->label('Set')
                    ->formatStateUsing(fn (Logo $record) => 'Logo Set #' . $record->id)
                    ->badge()
                    ->color('gray')
                    ->sortable(),
                ImageColumn::make('pres_gov')
                    ->label('National')
                    ->disk('public')
                    ->square()
                    ->size(72),
                ImageColumn::make('lgu_hilongos')
                    ->label('LGU')
                    ->disk('public')
                    ->square()
                    ->size(72),
                IconColumn::make('is_published')
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
                    ->color('info')
                    ->modal()
                    ->infolist([
                        \Filament\Infolists\Components\Section::make('Logo set overview')
                            ->description('Preview the uploaded logo assets and verify whether this set is the currently published version.')
                            ->schema([
                                \Filament\Infolists\Components\Grid::make(2)
                                    ->schema([
                                        \Filament\Infolists\Components\ImageEntry::make('pres_gov')
                                            ->label('Provincial government logo')
                                            ->disk('public')
                                            ->height(160),
                                        \Filament\Infolists\Components\ImageEntry::make('lgu_hilongos')
                                            ->label('LGU Hilongos logo')
                                            ->disk('public')
                                            ->height(160),
                                    ]),
                                \Filament\Infolists\Components\Grid::make(2)
                                    ->schema([
                                        \Filament\Infolists\Components\IconEntry::make('is_published')
                                            ->label('Active published set')
                                            ->boolean(),
                                        \Filament\Infolists\Components\TextEntry::make('created_at')
                                            ->label('Created')
                                            ->dateTime('F d, Y h:i A'),
                                    ]),
                            ]),
                    ]),

                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('publish')
                    ->label('Set Active')
                    ->icon('heroicon-o-check-badge')
                    ->color('success')
                    ->visible(fn (Logo $record) => ! $record->is_published)
                    ->requiresConfirmation()
                    ->modalHeading('Set Active Logo Set')
                    ->modalDescription('This will make the selected logo set the active published version and unpublish any previously active set.')
                    ->modalSubmitActionLabel('Set Active')
                    ->action(function (Logo $record) {
                        $record->publishAsActive();

                        Notification::make()
                            ->title('Active Logo Updated')
                            ->body('The selected logo set is now the active published version.')
                            ->success()
                            ->send();
                    }),
                Tables\Actions\DeleteAction::make()
                    ->label('Delete')
                    ->icon('heroicon-o-trash')
                    ->color('danger')
                    ->requiresConfirmation(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()
                    ->label('Delete Selected')
                    ->icon('heroicon-o-trash')
                    ->color('danger')
                    ->requiresConfirmation(),
            ]);
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
            'index' => Pages\ListLogos::route('/'),
            'create' => Pages\CreateLogo::route('/create'),
            'edit' => Pages\EditLogo::route('/{record}/edit'),
        ];
    }
}
