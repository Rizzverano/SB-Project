<?php

namespace App\Filament\Resources;

use App\Enums\Permission;
use App\Filament\Resources\UserResource\Pages;
use App\Mail\UserAccountStatusMail;
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
use Illuminate\Support\HtmlString;
use Illuminate\Support\Facades\Mail;
use Throwable;
use Filament\Tables\Contracts\HasTable;

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
            UserModel::ADMIN  => Permission::adminPermissions(),
            UserModel::MEMBER => Permission::memberPermissions(),
            default           => [],
        };

        $permissionValues = array_map(fn($p) => $p->value, $permissions);
        return in_array($permission->value, $permissionValues, true);
    }

    public static function getRoleLabel(int|string|null $role): string
    {
        return match ((int) $role) {
            UserModel::ADMIN => 'Admin',
            UserModel::MEMBER => 'Member',
            default => 'User',
        };
    }

    public static function sendAccountCreatedEmail(UserModel $user): void
    {
        $role = self::getRoleLabel($user->role);

        self::sendAccountEmail($user, new UserAccountStatusMail(
            $user->name,
            "Your Account has been created by the admin as {$role}. Please Proceed to the legislative building and ask for your credentials.",
            'Your Account Has Been Created',
        ));
    }

    public static function sendAccountEditedEmail(UserModel $user): void
    {
        $role = self::getRoleLabel($user->role);

        self::sendAccountEmail($user, new UserAccountStatusMail(
            $user->name,
            "Your Account has been edited by the admin as {$role}. Please Proceed to the legislative building and ask for your new credentials.",
            'Your Account Has Been Edited',
        ));
    }

    public static function sendAccountDeactivatedEmail(UserModel $user): void
    {
        self::sendAccountEmail($user, new UserAccountStatusMail(
            $user->name,
            'Your account has been deactivated by the admin. Please Proceed to the legislative building for permission to restore.',
            'Your Account Has Been Deactivated',
        ));
    }

    public static function sendAccountDeletedEmail(UserModel $user): void
    {
        self::sendAccountEmail($user, new UserAccountStatusMail(
            $user->name,
            'Your Account has been deleted by the admin.',
            'Your Account Has Been Deleted',
        ));
    }

    public static function sendAccountRestoredEmail(UserModel $user): void
    {
        self::sendAccountEmail($user, new UserAccountStatusMail(
            $user->name,
            'Your account has been restored by the admin.',
            'Your Account Has Been Restored',
        ));
    }

    protected static function sendAccountEmail(UserModel $user, UserAccountStatusMail $mail): void
    {
        try {
            Mail::to($user->email)->send($mail);
        } catch (Throwable $exception) {
            report($exception);

            Notification::make()
                ->title('Account email not sent')
                ->body("The account was updated, but the email to {$user->email} could not be sent.")
                ->warning()
                ->send();
        }
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
                ->required(fn(string $operation) => $operation === 'create')
                ->dehydrateStateUsing(fn($state) => filled($state) ? Hash::make($state) : null)
                ->dehydrated(fn($state) => filled($state))
                ->rule('confirmed')
                ->regex('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*])\S+$/')
                ->helperText(new HtmlString('
                    <div class="grid grid-cols-2 gap-x-6 gap-y-1 mt-2 text-xs text-gray-400">
                        <span>• At least 8 characters</span>
                        <span>• One uppercase letter</span>
                        <span>• One lowercase letter</span>
                        <span>• One number</span>
                        <span>• One symbol (! @ # $ % ^ & *)</span>
                    </div>
                '))
                ->validationMessages([
                    'min'       => 'Password must be at least 12 characters.',
                    'confirmed' => 'Password confirmation does not match.',
                    'regex'     => 'Password must have at least 12 characters, one uppercase letter, one lowercase letter, one number, and one symbol (! @ # $ % ^ & *).',
                ]),

            TextInput::make('password_confirmation')
                ->label('Confirm Password')
                ->password()
                ->revealable()
                ->same('password')
                ->dehydrated(false)
                ->required(fn(string $operation) => $operation === 'create')
                ->validationMessages([
                    'same' => 'Passwords do not match.',
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
                    ->formatStateUsing(fn($state) => match ($state) {
                        0 => 'Admin',
                        1 => 'Member',
                    })
                    ->badge()
                    ->color(fn($state) => match ($state) {
                        0 => 'danger',
                        1 => 'success',
                    }),
                TextColumn::make('created_at')->dateTime()->label('Created'),
            ])
            ->striped()
            ->paginated([10, 25, 50])
            ->filters([])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->color('info')
                    ->modal()
                    ->infolist([
                        \Filament\Infolists\Components\TextEntry::make('id')
                            ->label('ID'),
                        \Filament\Infolists\Components\TextEntry::make('name')
                            ->label('Name'),
                        \Filament\Infolists\Components\TextEntry::make('email')
                            ->label('Email'),
                        \Filament\Infolists\Components\TextEntry::make('role')
                            ->label('Role')
                            ->badge()
                            ->formatStateUsing(fn($state) => match ($state) {
                                0 => 'Admin',
                                1 => 'Member',
                            })
                            ->color(fn($state) => match ($state) {
                                0 => 'danger',
                                1 => 'success',
                            }),
                        \Filament\Infolists\Components\TextEntry::make('created_at')
                            ->label('Created')
                            ->dateTime(),
                    ]),

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
                        self::sendAccountDeactivatedEmail($record);

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
                    ->action(function (Collection $records, array $data, HasTable $livewire) {

                        if (!Hash::check($data['admin_password'], auth()->user()->password)) {
                            Notification::make()
                                ->title('Incorrect admin password')
                                ->danger()
                                ->send();
                            return;
                        }

                        foreach ($records as $record) {
                            $record->update(['is_active' => false]);
                            self::sendAccountDeactivatedEmail($record);

                            if (auth()->id() === $record->id) {
                                auth()->logout();
                            }
                        }

                        // ✅ CLEAR SELECTION
                        $livewire->deselectAllTableRecords();

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
            'edit'   => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
