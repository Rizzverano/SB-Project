<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
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
                ->action(function (array $data) {
                    if (!Hash::check($data['admin_password'], Auth::user()->password)) {
                        Notification::make()
                            ->title('Incorrect Password')
                            ->body('The admin password you entered is incorrect.')
                            ->danger()
                            ->send();

                        return;
                    }

                    $this->record->update([
                        'is_active' => false,
                    ]);
                    UserResource::sendAccountDeactivatedEmail($this->record);

                    if (auth()->id() === $this->record->id) {
                        auth()->logout();
                    }

                    Notification::make()
                        ->title('Account Deactivated')
                        ->body("{$this->record->name}'s account has been deactivated successfully. An email has been sent to notify the user.")
                        ->success()
                        ->send();

                    return redirect($this->getResource()::getUrl('index'));
                }),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // ✅ Validate admin password
        if (!Hash::check($data['admin_password'], auth()->user()->password)) {
            Notification::make()
                ->title('Incorrect admin password')
                ->body('The admin password you entered is incorrect.')
                ->danger()
                ->send();

            $this->halt(); // stops the save
        }

        unset($data['admin_password']); // remove before saving
        return $data;
    }

    protected function afterSave(): void
    {
        UserResource::sendAccountEditedEmail($this->record);

        // ✅ Success Notification
        Notification::make()
            ->title('Account Updated')
            ->body("{$this->record->name}'s account has been updated successfully. An email has been sent to notify the user.")
            ->success()
            ->send();

    }
}
