<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Filament\Notifications\Notification;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (!Hash::check($data['admin_password'], Auth::user()->password)) {
            Notification::make()->title('Incorrect admin password')->danger()->send();

            $this->halt();
        }

        unset($data['admin_password']);

        return $data;
    }
}
