<?php

namespace App\Filament\Resources;

use App\Enums\Permission;
use App\Models\User;
use App\Filament\Resources\OrdinanceResource\Pages;
use App\Models\Ordinance;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Collection;
use Filament\Forms\Components\DatePicker;

class OrdinanceResource extends Resource
{
    protected static ?string $model = Ordinance::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Ordinance';
    protected static ?string $navigationLabel = 'Ordinance Records';
    protected static ?int $navigationSort = 3;

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
        return self::hasPermission(Permission::ORDINANCE);
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('title')->required()->maxLength(150)->columnSpanFull(),

            Textarea::make('description')->rows(5)->columnSpanFull(),

            TextInput::make('sponsor'),

            TextInput::make('action'),

            DatePicker::make('date')
                ->label('Date')
                ->native(false),

            TextInput::make('publish_through'),

            FileUpload::make('file')
                ->directory('ordinances')
                ->disk('public')
                ->acceptedFileTypes(['application/pdf'])
                ->maxSize(51200)->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(static::getEloquentQuery()->where('is_archived', false))
            ->columns([
                TextColumn::make('title')
                    ->searchable(),

                TextColumn::make('description')
                    ->searchable(),

                Tables\Columns\TextColumn::make('sponsor')
                    ->label('Sponsor')
                    ->searchable(),

                Tables\Columns\TextColumn::make('action')
                    ->label('Action taken'),

                TextColumn::make('publish_through')
                    ->searchable(),

                Tables\Columns\TextColumn::make('date')
                    ->label('Date Published')
                    ->date('M d, Y')
                    ->sortable(),

                TextColumn::make('file')
                    ->label('PDF')
                    ->formatStateUsing(fn ($state) => $state ? '📄 View PDF' : 'No File')
                    ->url(fn ($record) =>
                        $record->file ? asset('storage/' . $record->file) : null
                    )
                    ->openUrlInNewTab(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),

                Tables\Actions\Action::make('preview')
                    ->label('Preview')
                    ->icon('heroicon-o-eye')
                    ->modalHeading('PDF Preview')
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Close')
                    ->modalContent(function ($record) {
                        $url = asset('storage/' . $record->file);

                        return view('filament.preview.pdf', compact('url'));
                    }),

                Tables\Actions\Action::make('archive')
                    ->label('Archive')
                    ->icon('heroicon-o-archive-box')
                    ->color('warning')
                    ->requiresConfirmation()
                    ->modalHeading('Archive Ordinance')
                    ->modalDescription('Are you sure you would like to archive this ordinance?')
                    ->modalSubmitActionLabel('Archive')
                    ->action(function ($record) {
                        $record->update([
                            'is_archived' => true,
                        ]);

                        Notification::make()
                            ->title('Ordinance Archived')
                            ->body('The ordinance has been archived successfully.')
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
                    ->action(function (Collection $records) {
                        $records->each->update([
                            'is_archived' => true,
                        ]);

                        Notification::make()
                            ->title('Ordinances Archived')
                            ->body('Selected ordinances have been archived successfully.')
                            ->success()
                            ->send();
                    }),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrdinances::route('/'),
            'create' => Pages\CreateOrdinance::route('/create'),
            'edit' => Pages\EditOrdinance::route('/{record}/edit'),
        ];
    }
}
