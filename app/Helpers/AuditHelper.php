<?php

namespace App\Helpers;

use App\Models\AuditLog;

class AuditHelper
{
    public static function log(
        string $action,
        string $module,
        int $recordId,
        string $description,
        ?string $status = null,
        ?bool $isLocked = null,
        ?bool $hasChallenge = null,
        ?string $failureReason = null
    ): void {

        // ✅ ONLY allow status-related fields for LOGIN
        if (strtolower($module) !== 'auth' && strtolower($action) !== 'login') {
            $status = null;
            $isLocked = null;
            $hasChallenge = null;
            $failureReason = null;
        }

        AuditLog::create([
            'email' => auth()->user()?->email ?? 'system',
            'ip_address' => request()?->ip() ?? '127.0.0.1',
            'user_agent' => request()?->userAgent() ?? 'System',

            'status' => $status,
            'failure_reason' => $failureReason,
            'is_locked' => $isLocked,
            'has_challenge' => $hasChallenge,

            'attempted_at' => now(),

            'action' => $action,
            'module' => $module,
            'record_id' => $recordId,
            'performed_by' => auth()->user()?->name ?? 'System',
            'description' => $description,

            'is_archived' => false,
        ]);
    }
}
