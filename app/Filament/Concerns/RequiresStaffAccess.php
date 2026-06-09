<?php

namespace App\Filament\Concerns;

trait RequiresStaffAccess
{
    public static function canAccess(): bool
    {
        return auth()->user()?->isStaff() === true;
    }

    public static function canViewAny(): bool
    {
        return static::canAccess();
    }

    public static function shouldRegisterNavigation(): bool
    {
        return static::canAccess();
    }
}
