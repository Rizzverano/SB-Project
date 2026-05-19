<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    use HasFactory;

    public const STATUS_SUCCESS = 'success';

    public const STATUS_FAILED = 'failed';

    protected $fillable = [
        'email',
        'ip_address',
        'user_agent',
        'status',
        'attempted_at',
        'failure_reason',
        'is_locked',
        'has_challenge',
        'is_archived',

         // NEW
        'action',
        'module',
        'record_id',
        'performed_by',
        'description',
    ];

    protected $casts = [
        'attempted_at' => 'datetime',
        'is_locked' => 'boolean',
        'has_challenge' => 'boolean',
        'is_archived' => 'boolean',
    ];
}
