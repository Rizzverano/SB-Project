<?php

namespace App\Models;

use App\Helpers\AuditHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LegislativeRecord extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'session',
        'date',
        'title',
        'description',
        'sponsor',
        'action_taken',
    ];

    protected static function booted()
    {
        static::created(function ($record) {
            AuditHelper::log(
                'Created',
                'Orbos',
                $record->id,
                'Created Orbos record: ' . $record->title
            );
        });

        static::updated(function ($record) {
            AuditHelper::log(
                'Updated',
                'Orbos',
                $record->id,
                'Updated Orbos record: ' . $record->title
            );
        });

        static::deleted(function ($record) {
            AuditHelper::log(
                'Archived',
                'Orbos',
                $record->id,
                'Archived Orbos record: ' . $record->title
            );
        });

        static::restored(function ($record) {
            AuditHelper::log(
                'Restored',
                'Orbos',
                $record->id,
                'Restored Orbos record: ' . $record->title
            );
        });
    }
}
