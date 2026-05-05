<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sbmember extends Model
{
    use HasFactory;

    protected $fillable = [
        'image',
        'name',
        'description',
        'is_publish',
        'is_archived',
    ];

    protected $casts = [
        'is_publish' => 'boolean',
        'is_archived' => 'boolean',
    ];
}
