<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganizationalChart extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'file',
        'is_publish',
        'starting_term',
        'ending_term',
    ];

    protected $casts = [
        'is_publish' => 'boolean',
        'starting_term' => 'date',
        'ending_term' => 'date',
    ];

}
