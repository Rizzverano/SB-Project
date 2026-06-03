<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\SpamHelper;
use Illuminate\Support\Str;

class ContactMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'message',
        'is_read',
        'is_archived',
        'is_spam',
        'ip_address',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'is_archived' => 'boolean',
        'is_spam' => 'boolean',
    ];

    protected static function booted()
    {
        static::creating(function ($message) {
            if (SpamHelper::containsSpam($message->message)) {
                $message->is_spam = true;
            }

            if (! empty($message->email)) {
                $message->email = Str::lower(trim($message->email));
            }
        });
    }
}
