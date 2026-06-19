<?php

namespace App\Services;

use App\Models\Experiment;
use App\Models\ExperimentVariant;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class ExperimentService
{
    /**
     * Get active experiments for current user/context
     */
    public function getActiveExperiments(array $context = []): array
    {
        $cacheKey = 'active_experiments_' . md5(serialize($context));

        return Cache::remember($cacheKey, 300, function () use ($context) {
            return Experiment::where('status', 'active')
                ->where(function ($query) {
                    $query->whereNull('start_date')
                          ->orWhere('start_date', '<=', now());
                })
                ->where(function ($query) {
                    $query->whereNull('end_date')
                          ->orWhere('end_date', '>=', now());
                })
                ->when(isset($context['user_id']), function ($query) use ($context) {
                    // Filter by target audience if specified
                    $query->where(function ($q) use ($context) {
                        $q->whereNull('target_audience')
                          ->orWhereJsonContains('target_audience', ['user_id' => $context['user_id']]);
                    });
                })
                ->with('variants')
                ->get()
                ->toArray();
        });
    }

    /**
     * Assign user to experiment variant
     */
    public function assignVariant(Experiment $experiment, string $sessionId, array $context = []): ?ExperimentVariant
    {
        // Check if user already assigned
        $cacheKey = "experiment_{$experiment->id}_session_{$sessionId}";
        $assignedVariantId = Cache::get($cacheKey);

        if ($assignedVariantId) {
            return ExperimentVariant::find($assignedVariantId);
        }

        // Check if user qualifies for experiment
        if (!$this->userQualifies($experiment, $context)) {
            return null;
        }

        // Get random variant based on traffic allocation
        $variant = $experiment->getRandomVariant($sessionId);

        if ($variant) {
            // Cache assignment for 24 hours
            Cache::put($cacheKey, $variant->id, 86400);

            // Track assignment event
            $variant->trackEvent('assignment', $sessionId, [
                'assigned_at' => now(),
                'context' => $context,
            ], $context['user_id'] ?? null);
        }

        return $variant;
    }

    /**
     * Track experiment event
     */
    public function trackEvent(string $experimentKey, string $eventType, string $sessionId, array $eventData = [], array $context = []): bool
    {
        $experiment = Experiment::where('key', $experimentKey)->first();

        if (!$experiment || !$experiment->isActive()) {
            return false;
        }

        $variant = $this->assignVariant($experiment, $sessionId, $context);

        if (!$variant) {
            return false;
        }

        $variant->trackEvent($eventType, $sessionId, $eventData, $context['user_id'] ?? null);

        return true;
    }

    /**
     * Get experiment results for reporting
     */
    public function getExperimentResults(string $experimentKey): ?array
    {
        $experiment = Experiment::where('key', $experimentKey)
            ->with(['variants.results'])
            ->first();

        if (!$experiment) {
            return null;
        }

        return [
            'experiment' => $experiment,
            'summary' => $experiment->getResultsSummary(),
            'stats' => [
                'total_participants' => $experiment->results()->distinct('session_id')->count(),
                'total_events' => $experiment->results()->count(),
                'duration_days' => $experiment->start_date ? $experiment->start_date->diffInDays(now()) : 0,
                'conversion_rates' => $experiment->variants->mapWithKeys(function ($variant) {
                    return [$variant->key => $variant->getConversionRate()];
                }),
            ],
        ];
    }

    /**
     * Check if user qualifies for experiment
     */
    private function userQualifies(Experiment $experiment, array $context): bool
    {
        // Check traffic percentage
        if ($experiment->traffic_percentage < 100) {
            $random = mt_rand(1, 10000) / 100;
            if ($random > $experiment->traffic_percentage) {
                return false;
            }
        }

        // Check target audience criteria
        if ($experiment->target_audience) {
            foreach ($experiment->target_audience as $criteria) {
                if (!$this->matchesCriteria($criteria, $context)) {
                    return false;
                }
            }
        }

        // Check geo targeting (country/city based)
        $geoRules = $experiment->target_audience['geo'] ?? null;
        if ($geoRules && !$this->checkGeoTargeting($geoRules, $context)) {
            return false;
        }

        // Check device type
        $deviceTypes = $experiment->target_audience['device_types'] ?? [];
        if (!empty($deviceTypes)) {
            $userDevice = $context['device_type'] ?? 'desktop';
            if (!in_array($userDevice, $deviceTypes)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Check geo targeting rules
     */
    private function checkGeoTargeting(array $geoRules, array $context): bool
    {
        $country = $context['country'] ?? ($context['country_code'] ?? null);
        $city = $context['city'] ?? null;

        // Include only specified countries
        if (!empty($geoRules['countries'])) {
            if ($country && !in_array(strtoupper($country), array_map('strtoupper', $geoRules['countries']))) {
                return $geoRules['mode'] === Experiment::GEO_EXCLUDE;
            }
        }

        // Exclude specified countries
        if (!empty($geoRules['exclude_countries'])) {
            if ($country && in_array(strtoupper($country), array_map('strtoupper', $geoRules['exclude_countries']))) {
                return false;
            }
        }

        // Include only specified cities
        if (!empty($geoRules['cities'])) {
            if ($city && !in_array(strtolower($city), array_map('strtolower', $geoRules['cities']))) {
                return $geoRules['mode'] === Experiment::GEO_EXCLUDE;
            }
        }

        return true;
    }

    /**
     * Check if user matches audience criteria
     */
    private function matchesCriteria(array $criteria, array $context): bool
    {
        foreach ($criteria as $key => $value) {
            switch ($key) {
                case 'user_id':
                    if (($context['user_id'] ?? null) !== $value) {
                        return false;
                    }
                    break;
                case 'country':
                    if (($context['country'] ?? null) !== $value) {
                        return false;
                    }
                    break;
                case 'device_type':
                    if (($context['device_type'] ?? null) !== $value) {
                        return false;
                    }
                    break;
                case 'user_role':
                    if (($context['user_role'] ?? null) !== $value) {
                        return false;
                    }
                    break;
                // Add more criteria as needed
            }
        }

        return true;
    }

    /**
     * Get user's current experiment assignments
     */
    public function getUserAssignments(string $sessionId): array
    {
        $assignments = [];
        $experiments = $this->getActiveExperiments();

        foreach ($experiments as $experiment) {
            $cacheKey = "experiment_{$experiment['id']}_session_{$sessionId}";
            $variantId = Cache::get($cacheKey);

            if ($variantId) {
                $variant = collect($experiment['variants'])->firstWhere('id', $variantId);
                if ($variant) {
                    $assignments[$experiment['key']] = $variant;
                }
            }
        }

        return $assignments;
    }

    /**
     * Clear experiment cache for user
     */
    public function clearUserCache(string $sessionId): void
    {
        $experiments = Experiment::all();

        foreach ($experiments as $experiment) {
            Cache::forget("experiment_{$experiment->id}_session_{$sessionId}");
        }
    }

    /**
     * Get experiment performance metrics
     */
    public function getPerformanceMetrics(Experiment $experiment): array
    {
        $results = $experiment->results()
            ->selectRaw('variant_id, event_type, count(*) as count, avg(timestampdiff(second, occurred_at, now())) as avg_time')
            ->groupBy('variant_id', 'event_type')
            ->get();

        $metrics = [];

        foreach ($results as $result) {
            $variantKey = $experiment->variants->find($result->variant_id)?->key ?? 'unknown';

            if (!isset($metrics[$variantKey])) {
                $metrics[$variantKey] = [
                    'variant_name' => $experiment->variants->find($result->variant_id)?->name ?? 'Unknown',
                    'events' => [],
                    'total_events' => 0,
                ];
            }

            $metrics[$variantKey]['events'][$result->event_type] = [
                'count' => $result->count,
                'avg_time_seconds' => round($result->avg_time, 2),
            ];

            $metrics[$variantKey]['total_events'] += $result->count;
        }

        return $metrics;
    }
}