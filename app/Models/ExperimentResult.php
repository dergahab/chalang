<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExperimentResult extends Model
{
    protected $fillable = [
        'experiment_id',
        'variant_id',
        'session_id',
        'user_id',
        'event_type',
        'event_name',
        'event_data',
        'page_url',
        'user_agent',
        'ip_address',
        'occurred_at',
    ];

    protected $casts = [
        'event_data' => 'array',
        'user_agent' => 'array',
        'occurred_at' => 'datetime',
    ];

    public $timestamps = false;

    // Relationships
    public function experiment(): BelongsTo
    {
        return $this->belongsTo(Experiment::class);
    }

    public function variant(): BelongsTo
    {
        return $this->belongsTo(ExperimentVariant::class, 'variant_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Scopes
    public function scopeByEventType($query, string $eventType)
    {
        return $query->where('event_type', $eventType);
    }

    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('occurred_at', [$startDate, $endDate]);
    }

    public function scopeUniqueSessions($query)
    {
        return $query->select('session_id')->distinct();
    }
}
