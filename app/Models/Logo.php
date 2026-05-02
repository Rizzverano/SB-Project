<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logo extends Model
{
    use HasFactory;

    protected $fillable = [
        'pres_gov',
        'lgu_hilongos',
        'is_published',
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function publishAsActive(): void
    {
        static::query()
            ->whereKeyNot($this->getKey())
            ->update(['is_published' => false]);

        if (! $this->is_published) {
            $this->forceFill(['is_published' => true])->save();
        }
    }
}
