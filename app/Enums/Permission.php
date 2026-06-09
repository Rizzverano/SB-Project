<?php

namespace App\Enums;

enum Permission: string
{
    case DASHBOARD = 'dashboard';
    case ORBUS = 'orbus';
    case ORDINANCE = 'ordinance';
    case ANNOUNCEMENTS = 'announcements';
    case LOGO_SETS = 'logo_sets';
    case RECORDS = 'records';
    case USERS = 'users';

    /**
     * Get all permissions for Admin role (full control)
     */
    public static function adminPermissions(): array
    {
        return [
            self::DASHBOARD,
            self::ORBUS,
            self::ORDINANCE,
            self::ANNOUNCEMENTS,
            self::LOGO_SETS,
            self::RECORDS,
            self::USERS,
        ];
    }

    /**
     * Get all permissions for Member role
     * Dashboard, Orbus, Ordinance, Announcements, Logo sets, Records control
     */
    public static function memberPermissions(): array
    {
        return [
            self::DASHBOARD,
            self::ORBUS,
            self::ORDINANCE,
            self::ANNOUNCEMENTS,
            self::LOGO_SETS,
            self::RECORDS,
        ];
    }

    /**
     * Get permissions for Spectator role
     * Dashboard only
     */
    public static function spectatorPermissions(): array
    {
        return [
            self::DASHBOARD,
        ];
    }


    /**
     * Get permissions for a specific role
     */
    public static function forRole(int $role): array
    {
        return match ($role) {
            \App\Models\User::ADMIN => self::adminPermissions(),
            \App\Models\User::MEMBER => self::memberPermissions(),
            \App\Models\User::SPECTATOR => self::spectatorPermissions(),
            default => [],
        };
    }

    /**
     * Get all available permissions
     */
    public static function all(): array
    {
        return [
            self::DASHBOARD,
            self::ORBUS,
            self::ORDINANCE,
            self::ANNOUNCEMENTS,
            self::LOGO_SETS,
            self::RECORDS,
            self::USERS,
        ];
    }

    /**
     * Get the label for display
     */
    public function label(): string
    {
        return match ($this) {
            self::DASHBOARD => 'Dashboard',
            self::ORBUS => 'Orbus',
            self::ORDINANCE => 'Ordinance',
            self::ANNOUNCEMENTS => 'Announcements',
            self::LOGO_SETS => 'Logo Sets',
            self::RECORDS => 'Records',
            self::USERS => 'Users',
        };
    }
}
