<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SbTarget extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'published',
    ];

    protected $casts = [
        'published' => 'boolean',
    ];
}
