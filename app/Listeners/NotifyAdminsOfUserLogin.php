<?php

namespace App\Listeners;

use App\Models\User;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Auth\Events\Login;

class NotifyAdminsOfUserLogin
{
    public function handle(Login $event): void
    {
        if (! $event->user instanceof User || $event->user->isAdmin()) {
            return;
        }

        $admins = User::query()
            ->where('role', User::ADMIN)
            ->where('is_active', true)
            ->get();

        if ($admins->isEmpty()) {
            return;
        }

        $url = route('filament.admin.resources.users.view', ['record' => $event->user]);

        Notification::make()
            ->title('User Logged In')
            ->body("{$event->user->name} signed in to the admin panel.")
            ->icon('heroicon-o-user-circle')
            ->iconColor('info')
            ->viewData([
                'module' => 'Users',
                'url' => $url,
            ])
            ->actions([
                Action::make('view')
                    ->label('View user')
                    ->url($url)
                    ->markAsRead(),
            ])
            ->sendToDatabase($admins, isEventDispatched: true);
    }
}
