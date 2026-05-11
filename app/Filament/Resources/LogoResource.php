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

    protected static ?int $navigationSort = 10;

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
                        ->label('Provincial government logo')
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
            ->where('is_archived', false)
            ->latest())
            ->columns([
                TextColumn::make('id')
                    ->label('Set')
                    ->formatStateUsing(fn (Logo $record) => 'Logo Set #' . $record->id)
                    ->badge()
                    ->color('gray')
                    ->sortable(),
                ImageColumn::make('pres_gov')
                    ->label('Provincial')
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
                Tables\Actions\ViewAction::make()->color('info'),
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
                Tables\Actions\Action::make('archive')
                    ->label('Archive')
                    ->icon('heroicon-o-archive-box')
                    ->color('warning')
                    ->requiresConfirmation()
                    ->modalHeading('Archive Logo Set')
                    ->modalDescription('Are you sure you want to archive this logo set?')
                    ->modalSubmitActionLabel('Archive')
                    ->action(function (Logo $record) {
                        $record->update([
                            'is_archived' => true,
                            'is_published' => false,
                        ]);

                        Notification::make()
                            ->title('Logo Set Archived')
                            ->body('The logo set has been archived successfully.')
                            ->success()
                            ->send();
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkAction::make('archive')
                    ->label('Archive Selected')
                    ->icon('heroicon-o-archive-box')
                    ->color('warning')
                    ->requiresConfirmation()
                    ->modalHeading('Archive Logo Sets')
                    ->modalDescription('Are you sure you want to archive the selected logo sets?')
                    ->modalSubmitActionLabel('Archive')
                    ->action(function ($records) {
                        $records->each->update([
                            'is_archived' => true,
                            'is_published' => false,
                        ]);

                        Notification::make()
                            ->title('Logo Sets Archived')
                            ->body('Selected logo sets have been archived successfully.')
                            ->success()
                            ->send();
                    }),
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
            'view' => Pages\ViewLogo::route('/{record}'),
            'edit' => Pages\EditLogo::route('/{record}/edit'),
        ];
    }
}
