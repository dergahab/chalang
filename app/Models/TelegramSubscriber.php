<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TelegramSubscriber extends Model
{
    protected $fillable = [
        'user_id',
        'chat_id',
        'username',
        'verification_code',
        'verification_code_expires_at',
        'is_active',
        'is_silent',
        'notification_settings',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_silent' => 'boolean',
        'notification_settings' => 'json',
        'verification_code_expires_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
