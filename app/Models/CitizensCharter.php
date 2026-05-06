<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CitizensCharter extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'file',
        'is_publish',
        'is_archived',
    ];

    protected $casts = [
        'is_publish' => 'boolean',
        'is_archived' => 'boolean',
    ];
}
