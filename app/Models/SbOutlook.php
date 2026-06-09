<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SbOutlook extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'title',
        'description',
        'published',
    ];

    protected $casts = [
        'published' => 'boolean',
    ];
}
