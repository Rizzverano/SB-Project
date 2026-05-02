<?php

namespace App\Http\Middleware;

use App\Enums\Permission;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Handle an incoming request.
     * 
     * Usage in routes:
     * ->middleware(['permission:ordinance'])
     * ->middleware(['permission:announcements,records'])
     */
    public function handle(Request $request, Closure $next, string ...$permissions): Response
    {
        $user = $request->user();
        
        if (!$user) {
            return redirect('/login');
        }

        if (!$user->is_active) {
            abort(403, 'Your account is disabled.');
        }

        // Convert string permissions to enum
        $requiredPermissions = array_map(function ($perm) {
            return Permission::tryFrom($perm);
        }, $permissions);

        // Filter out any invalid permissions
        $requiredPermissions = array_filter($requiredPermissions);

        if (!$user->hasAnyPermission($requiredPermissions)) {
            abort(403, 'You do not have permission to access this resource.');
        }

        return $next($request);
    }
}