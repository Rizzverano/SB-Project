<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\SpamHelper;
use Illuminate\Support\Str;
use Filament\Notifications\Notification;
use App\Models\User;


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

        static::created(function ($message) {
            if ($message->is_spam) {

                $admins = User::where('role', User::ADMIN)
                    ->where('is_active', true)
                    ->get();

                if ($admins->isNotEmpty()) {

                    $snippet = Str::limit(strip_tags($message->message), 120);

                    Notification::make()
                        ->title('Spam Contact Message')
                        ->body("{$message->name} sent a message flagged as spam: \"{$snippet}\"")
                        ->icon('heroicon-o-shield-exclamation')
                        ->iconColor('danger')
                        ->viewData([
                            'module' => 'Contact Message',
                        ])
                        ->sendToDatabase($admins, isEventDispatched: true);
                }
            }
        });
    }
}
