<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfficialsImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'image',
        'published',
    ];

    protected $casts = [
        'published' => 'boolean',
    ];
}
