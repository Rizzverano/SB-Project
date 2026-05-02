<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\RecentAnnouncements;
use App\Filament\Widgets\RecentLegislativeRecords;
use App\Filament\Widgets\RecentOrdinances;
use Filament\Pages\Page;

class Dashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static ?string $navigationGroup = 'Main';
    protected static string $view = 'filament.pages.dashboard';
    protected static ?string $navigationLabel = 'Dashboard';
    protected static ?int $navigationSort = 0;
    protected static ?string $title = 'Dashboard';

    public string $activeTab = 'orbus';

    public static function canAccess(): bool
    {
        $user = auth()->user();
        if (!$user) return false;
        $permissions = match ($user->role) {
            \App\Models\User::ADMIN => \App\Enums\Permission::adminPermissions(),
            \App\Models\User::MEMBER => \App\Enums\Permission::memberPermissions(),
            default => [],
        };
        $permissionValues = array_map(fn($p) => $p->value, $permissions);
        return in_array(\App\Enums\Permission::DASHBOARD->value, $permissionValues, true);
    }

    // ✅ THIS is the correct method for custom pages
    public function getWidgets(): array
    {
        if ($this->activeTab === 'orbus') {
            return [
                RecentLegislativeRecords::class,
            ];
        }

        if ($this->activeTab === 'announcements') {
            return [
                RecentAnnouncements::class,
            ];
        }

        return [
            RecentOrdinances::class,
        ];
    }
}
