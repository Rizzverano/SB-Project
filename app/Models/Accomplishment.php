<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accomplishment extends Model
{
    use HasFactory;

    protected $fillable = [
        'committee_name',
        'ord_no',
        'ord_title',
        'published',
    ];

    protected $casts = [
        'published' => 'boolean',
    ];
}