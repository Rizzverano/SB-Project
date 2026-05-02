<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Filament\Notifications\Notification;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('deactivate')
                ->label('Deactivate User')
                ->icon('heroicon-o-user-minus')
                ->color('warning')
                ->requiresConfirmation()
                ->form([\Filament\Forms\Components\TextInput::make('admin_password')->label('Your Password')->password()->required()])
                ->action(function (array $data) {
                    if (!Hash::check($data['admin_password'], Auth::user()->password)) {
                        Notification::make()->title('Incorrect admin password')->danger()->send();

                        return;
                    }

                    $this->record->update([
                        'is_active' => false,
                    ]);

                    Notification::make()->title('User deactivated successfully')->success()->send();

                    return redirect($this->getResource()::getUrl('index'));
                }),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (!Hash::check($data['admin_password'], Auth::user()->password)) {
            Notification::make()->title('Incorrect admin password')->danger()->send();

            $this->halt();
        }

        unset($data['admin_password']);

        return $data;
    }
}
