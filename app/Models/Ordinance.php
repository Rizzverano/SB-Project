<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ordinance extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'file',
        'is_archived',
        'description',
        'sponsor',
        'action',
        'publish_through',
        'date',
        'not_applicable',
    ];

    protected $casts = [
        'is_archived' => 'boolean',
        'not_applicable' => 'boolean',
    ];
}
