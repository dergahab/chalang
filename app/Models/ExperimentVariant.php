<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ExperimentVariant extends Model
{
    protected $fillable = [
        'experiment_id',
        'name',
        'key',
        'description',
        'configuration',
        'traffic_weight',
        'is_control',
    ];

    protected $casts = [
        'configuration' => 'array',
        'traffic_weight' => 'decimal:2',
        'is_control' => 'boolean',
    ];

    // Relationships
    public function experiment(): BelongsTo
    {
        return $this->belongsTo(Experiment::class);
    }

    public function results(): HasMany
    {
        return $this->hasMany(ExperimentResult::class, 'variant_id');
    }

    // Helper methods
    public function getConfigurationValue(string $key, $default = null)
    {
        return data_get($this->configuration, $key, $default);
    }

    public function setConfigurationValue(string $key, $value): void
    {
        $config = $this->configuration ?? [];
        data_set($config, $key, $value);
        $this->configuration = $config;
    }

    public function trackEvent(string $eventType, string $sessionId, array $eventData = [], string $userId = null): ExperimentResult
    {
        return $this->results()->create([
            'experiment_id' => $this->experiment_id,
            'session_id' => $sessionId,
            'user_id' => $userId,
            'event_type' => $eventType,
            'event_name' => $eventData['name'] ?? null,
            'event_data' => $eventData,
            'page_url' => request()->fullUrl(),
            'user_agent' => request()->userAgent(),
            'ip_address' => request()->ip(),
            'occurred_at' => now(),
        ]);
    }

    public function getConversionRate(string $conversionEvent = 'conversion'): float
    {
        $totalViews = $this->results()->where('event_type', 'view')->count();
        if ($totalViews === 0) {
            return 0.0;
        }

        $conversions = $this->results()->where('event_type', $conversionEvent)->count();
        return round(($conversions / $totalViews) * 100, 2);
    }
}
