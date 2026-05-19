<?php

namespace App\Helpers;

use App\Models\AuditLog;

class AuditHelper
{
    public static function log(
        string $action,
        string $module,
        int $recordId,
        string $description
    ): void {
        AuditLog::create([
            'email' => auth()->user()?->email,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'status' => AuditLog::STATUS_SUCCESS,
            'attempted_at' => now(),

            'action' => $action,
            'module' => $module,
            'record_id' => $recordId,
            'performed_by' => auth()->user()?->name ?? 'Unknown',
            'description' => $description,

            'is_locked' => false,
            'has_challenge' => false,
            'is_archived' => false,
        ]);
    }
}
