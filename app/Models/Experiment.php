<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Experiment extends Model
{
    protected $fillable = [
        'name',
        'key',
        'description',
        'status',
        'type',
        'target_audience',
        'traffic_percentage',
        'start_date',
        'end_date',
        'goals',
        'created_by',
    ];

    protected $casts = [
        'target_audience' => 'array',
        'goals' => 'array',
        'traffic_percentage' => 'decimal:2',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    /**
     * Geo targeting types
     */
    public const GEO_INCLUDE = 'include';
    public const GEO_EXCLUDE = 'exclude';

    /**
     * Default geo rules
     */
public static function getDefaultGeoRules(): array
    {
        return [
            'countries' => [], // ISO 3166-1 alpha-2 codes: AZ, US, RU, TR, etc.
            'cities' => [],
            'platforms' => ['web', 'mobile'],
            'device_types' => ['desktop', 'tablet', 'mobile'],
        ];
    }

    // Relationships
    public function variants(): HasMany
    {
        return $this->hasMany(ExperimentVariant::class);
    }

    public function results(): HasManyThrough
    {
        return $this->hasManyThrough(ExperimentResult::class, ExperimentVariant::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Helper methods
    public function isActive(): bool
    {
        return $this->status === 'active' &&
               ($this->start_date === null || $this->start_date->isPast()) &&
               ($this->end_date === null || $this->end_date->isFuture());
    }

    public function getControlVariant()
    {
        return $this->variants()->where('is_control', true)->first();
    }

    public function getRandomVariant(string $sessionId = null): ?ExperimentVariant
    {
        if (!$this->isActive()) {
            return null;
        }

        $variants = $this->variants()->get();

        if ($variants->isEmpty()) {
            return null;
        }

        // If user already participated, return their assigned variant
        if ($sessionId) {
            $existingResult = ExperimentResult::where('experiment_id', $this->id)
                ->where('session_id', $sessionId)
                ->first();

            if ($existingResult) {
                return $existingResult->variant;
            }
        }

        // Random assignment based on traffic weights
        $totalWeight = $variants->sum('traffic_weight');
        $random = mt_rand(0, $totalWeight * 100) / 100;

        $cumulative = 0;
        foreach ($variants as $variant) {
            $cumulative += $variant->traffic_weight;
            if ($random <= $cumulative) {
                return $variant;
            }
        }

        // Fallback to first variant
        return $variants->first();
    }

    public function getResultsSummary()
    {
        return $this->variants()->withCount(['results' => function ($query) {
            $query->selectRaw('variant_id, event_type, count(*) as count')
                  ->groupBy('variant_id', 'event_type');
        }])->get()->map(function ($variant) {
            $results = $variant->results->groupBy('event_type');
            return [
                'variant_id' => $variant->id,
                'variant_name' => $variant->name,
                'is_control' => $variant->is_control,
                'traffic_weight' => $variant->traffic_weight,
                'events' => $results->map->count(),
                'unique_sessions' => $variant->results->unique('session_id')->count(),
            ];
        });
    }
}
