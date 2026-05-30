<?php

namespace App\Filament\Resources;

use App\Enums\Permission;
use App\Models\User;
use App\Filament\Resources\AnnouncementResource\Pages;
use App\Models\Announcement;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Tables\Table;

class AnnouncementResource extends Resource
{
    protected static ?string $model = Announcement::class;

    protected static ?string $navigationIcon = 'heroicon-o-megaphone';
    protected static ?string $navigationLabel = 'Announcements';
    protected static ?string $navigationGroup = 'Events';
    protected static ?int $navigationSort = 6;

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
        return self::hasPermission(Permission::ANNOUNCEMENTS);
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Announcement Details')
                ->schema([
                    Forms\Components\TextInput::make('title')
                        ->required()
                        ->placeholder('e.g. Waste Segregation, etc.')
                        ->maxLength(255)
                        ->columnSpanFull(),

                    Forms\Components\MarkdownEditor::make('description')
                        ->required()
                        ->placeholder('e.g. Proper Waste Management on Biodegradable Waste and Non-Biodegradable Waste for the citizens of Hilongos, etc.')
                        ->columnSpanFull(),
                ])
                ->columns(1),

            Forms\Components\Section::make('Visibility')
                ->schema([
                    Forms\Components\Toggle::make('published')
                        ->label('Publish Announcement')
                        ->helperText('Enable to make this visible to users.')
                        ->default(false),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(static::getEloquentQuery())
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('description')
                    ->limit(50)
                    ->wrap()
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
                    ->modal()
                    ->infolist([
                        \Filament\Infolists\Components\Section::make('Announcement overview')
                            ->description('Review the content, visibility status, and publishing timestamp for this announcement.')
                            ->schema([
                                \Filament\Infolists\Components\TextEntry::make('title')
                                    ->label('Title')
                                    ->weight('bold')
                                    ->columnSpanFull(),
                                \Filament\Infolists\Components\TextEntry::make('description')
                                    ->label('Description')
                                    ->markdown()
                                    ->placeholder('No description provided.')
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAnnouncements::route('/'),
            'create' => Pages\CreateAnnouncement::route('/create'),
            'edit' => Pages\EditAnnouncement::route('/{record}/edit'),
        ];
    }
}
