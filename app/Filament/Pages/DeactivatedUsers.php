<?php

namespace App\Filament\Pages;

use App\Models\User;
use Filament\Tables;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Pages\Page;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;

class DeactivatedUsers extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-user-minus';
    protected static ?string $navigationLabel = 'Deactivated Accounts';
    protected static ?string $navigationGroup = 'Users';
    protected static ?int $navigationSort = 9;

    protected static string $view = 'filament.pages.deactivated-users';

    // 🔒 Only Admin can access
    public static function canAccess(): bool
    {
        $user = auth()->user();

        return $user && $user->role === \App\Models\User::ADMIN;
    }

    // 📊 Query (same structure as UserResource)
    protected function getTableQuery(): Builder
    {
        return User::query()->where('is_active', false);
    }

    // 📋 Columns (matched to UserResource style)
    public function table(Table $table): Table
    {
        return $table
            ->query($this->getTableQuery())
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),

                TextColumn::make('name')
                    ->label('Name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),

                TextColumn::make('role')
                    ->label('Role')
                    ->formatStateUsing(fn ($state) => match ($state) {
                        0 => 'Admin',
                        1 => 'Member',
                    })
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        0 => 'danger',
                        1 => 'success',
                    }),

                TextColumn::make('updated_at')
                    ->label('Deactivated At')
                    ->dateTime('M d, Y h:i A')
                    ->sortable(),
            ])
            ->striped()
            ->paginated([10, 25, 50])
            ->defaultSort('updated_at', 'desc')

            // 🔥 Actions (same style as UserResource)
           ->actions([
                Action::make('restore')
                    ->label('Restore')
                    ->icon('heroicon-o-arrow-path')
                    ->color('success')
                    ->requiresConfirmation()
                    ->form([
                        TextInput::make('admin_password')
                            ->label('Your Password')
                            ->password()
                            ->required(),
                    ])
                    ->action(function (User $record, array $data) {

                        if (!Hash::check($data['admin_password'], auth()->user()->password)) {
                            Notification::make()
                                ->title('Incorrect admin password')
                                ->danger()
                                ->send();
                            return;
                        }

                        $record->update(['is_active' => true]);

                        Notification::make()
                            ->title('Account restored successfully')
                            ->success()
                            ->send();
                    }),

                Action::make('edit')
                    ->label('Edit')
                    ->icon('heroicon-o-pencil')
                    ->form([
                        TextInput::make('name')->required()->maxLength(50),
                        TextInput::make('email')->email()->required()->maxLength(50),

                        TextInput::make('password')
                            ->password()
                            ->revealable()
                            ->helperText('Leave blank if not changing'),

                        Select::make('role')
                            ->options([
                                0 => 'Admin',
                                1 => 'Member',
                            ])
                            ->required(),
                    ])
                    ->fillForm(fn (User $record) => [
                        'name' => $record->name,
                        'email' => $record->email,
                        'role' => $record->role,
                    ])
                    ->action(function (User $record, array $data) {
                        $update = [
                            'name' => $data['name'],
                            'email' => $data['email'],
                            'role' => $data['role'],
                        ];

                        if (!empty($data['password'])) {
                            $update['password'] = Hash::make($data['password']);
                        }

                        $record->update($update);

                        Notification::make()
                            ->title('User updated successfully')
                            ->success()
                            ->send();
                    }),

                Action::make('delete')
                    ->label('Delete')
                    ->icon('heroicon-o-trash')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->form([
                        TextInput::make('admin_password')
                            ->label('Your Password')
                            ->password()
                            ->required(),
                    ])
                    ->action(function (User $record, array $data) {

                        if (!Hash::check($data['admin_password'], auth()->user()->password)) {
                            Notification::make()
                                ->title('Incorrect admin password')
                                ->danger()
                                ->send();
                            return;
                        }

                        $record->delete();

                        Notification::make()
                            ->title('User deleted successfully')
                            ->danger()
                            ->send();
                    }),
            ])

            // 🔥 Bulk Actions (same style as UserResource)
            ->bulkActions([
                BulkAction::make('restoreSelected')
                    ->label('Restore Selected')
                    ->icon('heroicon-o-arrow-path')
                    ->color('success')
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
                            $record->update(['is_active' => true]);
                        }

                        Notification::make()
                            ->title('Selected accounts restored')
                            ->success()
                            ->send();
                    }),

                BulkAction::make('deleteSelected')
                    ->label('Delete Selected')
                    ->icon('heroicon-o-trash')
                    ->color('danger')
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
                            $record->delete();
                        }

                        Notification::make()
                            ->title('Selected accounts deleted')
                            ->danger()
                            ->send();
                    }),
            ]);
    }
}
