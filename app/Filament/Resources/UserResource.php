<?php

namespace App\Filament\Resources;

use App\Enums\Permission;
use App\Filament\Resources\UserResource\Pages;
use App\Models\User as UserModel;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\Select;
use Filament\Tables\Actions\BulkAction;
use Illuminate\Support\Collection;
use Filament\Notifications\Notification;

class UserResource extends Resource
{
    protected static ?string $model = UserModel::class;

    protected static ?string $navigationIcon = 'heroicon-m-users';

    protected static ?string $modelLabel = 'User Account';

    protected static ?string $navigationGroup = 'Users';

    protected static ?int $navigationSort = 8;

    protected static function hasPermission(Permission $permission): bool
    {
        $user = auth()->user();
        if (!$user) {
            return false;
        }

        $permissions = match ($user->role) {
            UserModel::ADMIN => Permission::adminPermissions(),
            UserModel::MEMBER => Permission::memberPermissions(),
            default => [],
        };

        $permissionValues = array_map(fn($p) => $p->value, $permissions);
        return in_array($permission->value, $permissionValues, true);
    }

    public static function canViewAny(): bool
    {
        return self::hasPermission(Permission::USERS);
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('name')
                ->label('Name')
                ->required()
                ->minLength(3)
                ->maxLength(50)
                ->regex('/^[a-zA-Z\s]+$/')
                ->validationMessages([
                    'required' => 'Name is required.',
                    'min'      => 'Name must be at least 3 characters.',
                    'max'      => 'Name must not exceed 50 characters.',
                    'regex'    => 'Name can only contain letters and spaces.',
                ]),

            TextInput::make('email')
                ->label('Email')
                ->email()
                ->required()
                ->maxLength(255)
                ->regex('/^\S*$/')
                ->unique(ignoreRecord: true)
                ->validationMessages([
                    'required' => 'Email is required.',
                    'email'    => 'Please enter a valid email address.',
                    'unique'   => 'This email is already taken.',
                    'regex'    => 'Email must not contain spaces.',
                ]),

            TextInput::make('password')
                ->label('Password')
                ->password()
                ->revealable()
                ->minLength(8)
                ->maxLength(255)
                ->regex('/^\S*$/')
                ->required(fn(string $operation) => $operation === 'create')
                ->dehydrateStateUsing(fn($state) => filled($state) ? Hash::make($state) : null)
                ->dehydrated(fn($state) => filled($state))
                ->rule('confirmed')
                ->validationMessages([
                    'min'       => 'Password must be at least 8 characters.',
                    'confirmed' => 'Password confirmation does not match.',
                    'regex'     => 'Password must not contain spaces.',
                ]),

            TextInput::make('password_confirmation')
                ->label('Confirm Password')
                ->password()
                ->revealable()
                ->same('password')
                ->regex('/^\S*$/')
                ->dehydrated(false)
                ->required(fn(string $operation) => $operation === 'create')
                ->validationMessages([
                    'same'  => 'Passwords do not match.',
                    'regex' => 'Password confirmation cannot contain spaces.',
                ]),

            Select::make('role')
                ->label('Role')
                ->required()
                ->options([
                    0 => 'Admin',
                    1 => 'Member',
                ])
                ->validationMessages([
                    'required' => 'Role is required.',
                ]),

            TextInput::make('admin_password')
                ->label('Your Password (Confirmation)')
                ->password()
                ->required()
                ->rules(['required', 'string', 'min:8'])
                ->validationMessages([
                    'required' => 'Please enter your admin password to continue.',
                    'min'      => 'Password is too short.',
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('ID')->sortable(),

                TextColumn::make('name')->label('Name')->searchable(),

                TextColumn::make('email')->label('Email')->searchable(),

                TextColumn::make('role')
                    ->label('Role')
                    ->formatStateUsing(
                        fn($state) => match ($state) {
                            0 => 'Admin',
                            1 => 'Member',
                        },
                    )
                    ->badge()
                    ->color(
                        fn($state) => match ($state) {
                            0 => 'danger',
                            1 => 'success',
                        },
                    ),

                TextColumn::make('created_at')->dateTime()->label('Created'),
            ])
            ->striped()
            ->paginated([10, 25, 50])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),

                Tables\Actions\Action::make('deactivate')
                    ->label('Deactivate')
                    ->icon('heroicon-o-user-minus')
                    ->color('warning')
                    ->requiresConfirmation()
                    ->modalHeading('Deactivate User Account')
                    ->modalDescription('This will deactivate the user account. They will no longer be able to log in.')
                    ->modalSubmitActionLabel('Yes, Deactivate')
                    ->form([
                        TextInput::make('admin_password')
                            ->label('Your Password')
                            ->password()
                            ->required()
                            ->validationMessages([
                                'required' => 'Please enter your admin password to continue.',
                            ]),
                    ])
                    ->action(function ($record, array $data) {
                        if (!Hash::check($data['admin_password'], auth()->user()->password)) {
                            Notification::make()
                                ->title('Incorrect Password')
                                ->body('The admin password you entered is incorrect.')
                                ->danger()
                                ->send();

                            return;
                        }

                        $record->update(['is_active' => false]);

                        if (auth()->id() === $record->id) {
                            auth()->logout();
                        }

                        Notification::make()
                            ->title('Account Deactivated')
                            ->body("{$record->name}'s account has been deactivated successfully.")
                            ->success()
                            ->send();
                    }),
            ])
            ->bulkActions([
                BulkAction::make('deactivate')
                    ->label('Deactivate selected')
                    ->icon('heroicon-o-user-minus')
                    ->color('warning')
                    ->requiresConfirmation()
                    ->form([
                        TextInput::make('admin_password')
                            ->label('Your Password')
                            ->password()
                            ->required(),
                    ])
                    ->action(function (Collection $records, array $data) {
                        if (!Hash::check($data['admin_password'], auth()->user()->password)) {
                            Notification::make()
                                ->title('Incorrect admin password')
                                ->danger()
                                ->send();

                            return;
                        }

                        foreach ($records as $record) {
                            $record->update(['is_active' => false]);

                            if (auth()->id() === $record->id) {
                                auth()->logout();
                            }
                        }

                        Notification::make()
                            ->title('Selected accounts deactivated successfully')
                            ->success()
                            ->send();
                    }),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('is_active', true);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'view'   => Pages\ViewUser::route('/{record}'),
            'edit'   => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
