<?php

namespace App\Models;

use App\Helpers\AuditHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ordinance extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'file',
        'is_archived',
        'published',
        'description',
        'sponsor',
        'action',
        'publish_through',
        'date',
        'not_applicable',
    ];

    protected $casts = [
        'is_archived' => 'boolean',
        'not_applicable' => 'boolean',
        'published' => 'boolean',
    ];

    public function scopePublished($query)
    {
        return $query->where('published', true);
    }

    protected static function booted()
    {
        static::created(function ($record) {
            AuditHelper::log(
                'Created',
                'Ordinance',
                $record->id,
                'Created Ordinance: ' . $record->title
            );
        });

        static::updated(function ($record) {
            AuditHelper::log(
                'Updated',
                'Ordinance',
                $record->id,
                'Updated Ordinance: ' . $record->title
            );
        });
    }
}
