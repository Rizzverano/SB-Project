<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganizationalChart extends Model
{
    use HasFactory;

    protected $fillable = [
        'file',
        'is_publish',
    ];

    protected $casts = [
        'is_publish' => 'boolean',
    ];

}
