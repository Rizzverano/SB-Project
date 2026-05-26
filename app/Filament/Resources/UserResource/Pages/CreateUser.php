<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Hash;
use Filament\Notifications\Notification;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // ✅ Validate admin password
        if (!Hash::check($data['admin_password'], auth()->user()->password)) {
            Notification::make()
                ->title('Incorrect admin password')
                ->body('The admin password you entered is incorrect.')
                ->danger()
                ->send();

            $this->halt(); // stops the create
        }

        unset($data['admin_password']); // remove before saving
        return $data;
    }

    protected function afterCreate(): void
    {
        UserResource::sendAccountCreatedEmail($this->record);

        // ✅ Success Notification
        Notification::make()
            ->title('Account Created')
            ->body("{$this->record->name}'s account has been created successfully. An email has been sent to notify the user.")
            ->success()
            ->send();
    }
}
