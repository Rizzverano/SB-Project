<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hero extends Model
{
    use HasFactory;

    protected $fillable = [
        'image1',
        'image2',
        'is_publish',
    ];

    protected $casts = [
        'is_publish' => 'boolean',
    ];

    public function scopePublished($query)
    {
        return $query->where('is_publish', true);
    }

    public function publishAsActive(): void
    {
        static::query()
            ->whereKeyNot($this->getKey())
            ->update(['is_publish' => false]);

        if (! $this->is_publish) {
            $this->forceFill(['is_publish' => true])->save();
        }
    }
}
