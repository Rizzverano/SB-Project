<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SbsecTarget extends Model
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
