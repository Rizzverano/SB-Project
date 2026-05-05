<?php

namespace App\Filament\Resources;

use App\Enums\Permission;
use App\Models\User;
use App\Filament\Resources\LegislativeRecordResource\Pages;
use App\Models\LegislativeRecord;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Actions\DeleteAction;
use Filament\Notifications\Notification;

class LegislativeRecordResource extends Resource
{
    protected static ?string $model = LegislativeRecord::class;

    protected static ?string $navigationLabel = 'ORBOS Records';

    protected static ?string $modelLabel = 'ORBOS Record';

    protected static ?string $pluralModelLabel = 'ORBOS Records';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'ORBOS';

    protected static ?int $navigationSort = 1;

    public function getTitle(): string
    {
        return 'ORBOS Records';
    }

    public function getHeading(): string
    {
        return 'ORBOS Records';
    }

    // 👇 PUT IT HERE
    public static function shouldRegisterNavigation(): bool
    {
        $user = auth()->user();

        if (!$user) return false;
        $permissions = match ($user->role) {
            User::ADMIN => Permission::adminPermissions(),
            User::MEMBER => Permission::memberPermissions(),
            default => [],
        };
        $permissionValues = array_map(fn($p) => $p->value, $permissions);
        return in_array(Permission::ORBUS->value, $permissionValues, true);
    }

    // (optional but recommended)
    public static function canAccess(): bool
    {
        $user = auth()->user();

        if (!$user) return false;
        $permissions = match ($user->role) {
            User::ADMIN => Permission::adminPermissions(),
            User::MEMBER => Permission::memberPermissions(),
            default => [],
        };
        $permissionValues = array_map(fn($p) => $p->value, $permissions);
        return in_array(Permission::ORBUS->value, $permissionValues, true);
    }

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

    protected static function hasAnyPermission(array $permissions): bool
    {
        $user = auth()->user();
        if (!$user) return false;

        $userPermissions = match ($user->role) {
            User::ADMIN => Permission::adminPermissions(),
            User::MEMBER => Permission::memberPermissions(),
            default => [],
        };

        $userPermissionValues = array_map(fn($p) => $p->value, $userPermissions);
        $requiredValues = array_map(fn($p) => $p->value, $permissions);
        return count(array_intersect($userPermissionValues, $requiredValues)) > 0;
    }

    public static function canViewAny(): bool
    {
        return self::hasAnyPermission([Permission::ORBUS, Permission::RECORDS]);
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('session')->placeholder('e.g., First Relugar Session, etc.')->required(),
            Forms\Components\DatePicker::make('date')->required(),
            Forms\Components\TextInput::make('title')->label('Legislative Title')->placeholder('e.g., Local Chief Executive Hour, etc.')->required()->columnSpanFull(),
            Forms\Components\MarkdownEditor::make('description')->columnSpanFull()->placeholder('e.g., In relation for franchise 3WETAXI, etc.')->required(),
            Forms\Components\TextInput::make('sponsor')->label('Sponsor')->placeholder('e.g., Hon. John Doe, etc.')->required(),
            Forms\Components\TextInput::make('action_taken')->label('Action Taken')->placeholder('e.g., Approved, Marked as Noted, etc.')->required()]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('session')->label('Session')->wrap()->searchable(),
                TextColumn::make('date')->label('Date')->date('F d, Y')->sortable(),
                TextColumn::make('title')
                    ->label('Orbus Record')
                    ->formatStateUsing(
                        fn($record) => "
                    <strong>{$record->title}</strong><br>
                    <small>{$record->description}</small>
                ",
                    )
                    ->html()
                    ->wrap()
                    ->searchable(),

                TextColumn::make('sponsor')->label('Sponsor')->wrap()->searchable(),

                TextColumn::make('action_taken')
                    ->label('Action Taken')
                    ->badge()
                    ->color(
                        fn($state) => match ($state) {
                            'Approved' => 'success',
                            'Marked as Noted' => 'gray',
                            'NONE' => 'secondary',
                            default => 'warning',
                        },
                    )
                    ->searchable(),
            ])
            ->defaultSort('date', 'desc')
            ->striped()
            ->paginated([10, 25, 50])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),

                DeleteAction::make()
                    ->label('Archive')
                    ->icon('heroicon-o-archive-box')
                    ->color('warning')
                    ->modalHeading('Archive Legislative Record')
                    ->modalDescription('Are you sure you would like to archive this legislative record?')
                    ->modalSubmitActionLabel('Archive')
                    ->successNotificationTitle('Legislative Record Archived')
                    ->successNotification(
                        Notification::make()
                            ->title('Legislative Record Archived')
                            ->body('The legislative record has been archived successfully.')
                            ->success()
                            ->duration(5000)
                    ),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()
                    ->label('Archive Selected')
                    ->icon('heroicon-o-archive-box')
                    ->color('warning')
                    ->modalHeading('Archive Legislative Records')
                    ->modalDescription('Are you sure you would like to archive the selected legislative records?')
                    ->modalSubmitActionLabel('Archive')
                    ->successNotificationTitle('Legislative Records Archived')
                    ->successNotification(
                        Notification::make()
                            ->title('Legislative Records Archived')
                            ->body('The selected legislative records have been archived successfully.')
                            ->success()
                            ->duration(5000)
                    ),
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
            'index' => Pages\ListLegislativeRecords::route('/'),
            'create' => Pages\CreateLegislativeRecord::route('/create'),
            'view' => Pages\ViewLegislativeRecord::route('/{record}'),
            'edit' => Pages\EditLegislativeRecord::route('/{record}/edit'),
        ];
    }
}
