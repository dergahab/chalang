<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TelegramNotificationLog extends Model
{
    protected $fillable = [
        'subscriber_id',
        'chat_id',
        'type',
        'message_preview',
        'status',
        'error_message',
        'attempts',
        'sent_at',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
        'attempts' => 'integer',
    ];

    public function subscriber(): BelongsTo
    {
        return $this->belongsTo(TelegramSubscriber::class, 'subscriber_id');
    }

    // Uğurlu göndərişlər
    public function scopeSent($query)
    {
        return $query->where('status', 'sent');
    }

    // Uğursuz göndərişlər
    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }
}
