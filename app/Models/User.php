<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;

class User extends Authenticatable implements FilamentUser
{
    use HasApiTokens, HasFactory, Notifiable;

    const ADMIN = 0;
    const MEMBER = 1;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_active',
        'login_otp_verified_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'login_otp_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function isActive(): bool
    {
        return $this->is_active;
    }

    public function canAccessPanel(Panel $panel): bool
    {
        if (!$this->is_active) {
            return false;
        }

        // Admin has full access
        if ($this->isAdmin()) {
            return true;
        }

        // Other roles need at least dashboard permission
        return $this->hasPermission(\App\Enums\Permission::DASHBOARD);
    }
    // Helper methods (very useful)
    public function isAdmin()
    {
        return $this->role === self::ADMIN;
    }

    public function isMember()
    {
        return $this->role === self::MEMBER;
    }


    /**
     * Check if user has a specific permission
     */
    public function hasPermission(\App\Enums\Permission $permission): bool
    {
        $permissions = \App\Enums\Permission::forRole($this->role);
        // Compare using value to handle string enums
        return in_array($permission->value, array_map(fn($p) => $p->value, $permissions), true);
    }

    /**
     * Check if user has any of the given permissions
     */
    public function hasAnyPermission(array $permissions): bool
    {
        $userPermissions = \App\Enums\Permission::forRole($this->role);
        $userPermissionValues = array_map(fn($p) => $p->value, $userPermissions);
        $requiredValues = array_map(fn($p) => $p->value, $permissions);
        return count(array_intersect($userPermissionValues, $requiredValues)) > 0;
    }

    /**
     * Check if user has all of the given permissions
     */
    public function hasAllPermissions(array $permissions): bool
    {
        $userPermissions = \App\Enums\Permission::forRole($this->role);
        $userPermissionValues = array_map(fn($p) => $p->value, $userPermissions);
        $requiredValues = array_map(fn($p) => $p->value, $permissions);
        return count(array_intersect($userPermissionValues, $requiredValues)) === count($requiredValues);
    }

    /**
     * Get all permissions for the user based on their role
     */
    public function getPermissions(): array
    {
        return \App\Enums\Permission::forRole($this->role);
    }

    /**
     * Check if user can access a specific Filament resource
     */
    public function canAccessFilamentResource(string $resource): bool
    {
        $resourcePermissionMap = [
            'Dashboard' => \App\Enums\Permission::DASHBOARD,
            'Orbus' => \App\Enums\Permission::ORBUS,
            'Ordinance' => \App\Enums\Permission::ORDINANCE,
            'Announcement' => \App\Enums\Permission::ANNOUNCEMENTS,
            'Logo' => \App\Enums\Permission::LOGO_SETS,
            'LegislativeRecord' => \App\Enums\Permission::RECORDS,
            'User' => \App\Enums\Permission::USERS,
        ];

        $permission = $resourcePermissionMap[$resource] ?? null;

        if (!$permission) {
            return $this->isAdmin();
        }

        return $this->hasPermission($permission);
    }
}
