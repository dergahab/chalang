<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AnalyticsEvent extends Model
{
    protected $fillable = [
        'user_id',
        'session_id',
        'event_type',
        'event_name',
        'event_data',
        'page_url',
        'page_title',
        'user_agent',
        'ip_address',
        'referrer',
        'device_type',
        'browser',
        'os',
        'country',
        'city',
        'experiment_id',
        'experiment_variant',
        'conversion_value',
        'timestamp'
    ];

    protected $casts = [
        'event_data' => 'array',
        'timestamp' => 'datetime',
        'conversion_value' => 'decimal:2'
    ];

    /**
     * Get the user that owns the event
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the experiment associated with this event
     */
    public function experiment(): BelongsTo
    {
        return $this->belongsTo(Experiment::class);
    }

    /**
     * Scope for conversion events
     */
    public function scopeConversions($query)
    {
        return $query->where('event_type', 'conversion');
    }

    /**
     * Scope for page views
     */
    public function scopePageViews($query)
    {
        return $query->where('event_type', 'page_view');
    }

    /**
     * Scope for clicks
     */
    public function scopeClicks($query)
    {
        return $query->where('event_type', 'click');
    }

    /**
     * Scope for events in date range
     */
    public function scopeDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('timestamp', [$startDate, $endDate]);
    }

    /**
     * Scope for events by experiment
     */
    public function scopeByExperiment($query, $experimentId)
    {
        return $query->where('experiment_id', $experimentId);
    }

    /**
     * Get top pages by views
     */
    public static function getTopPages($days = 30)
    {
        return static::pageViews()
            ->where('timestamp', '>=', now()->subDays($days))
            ->selectRaw('page_url, page_title, COUNT(*) as views')
            ->groupBy('page_url', 'page_title')
            ->orderBy('views', 'desc')
            ->limit(10)
            ->get();
    }

    /**
     * Get conversion funnel data
     */
    public static function getConversionFunnel($experimentId = null, $days = 30)
    {
        $query = static::where('timestamp', '>=', now()->subDays($days));

        if ($experimentId) {
            $query->where('experiment_id', $experimentId);
        }

        return $query->selectRaw('
            COUNT(CASE WHEN event_type = "page_view" THEN 1 END) as page_views,
            COUNT(CASE WHEN event_type = "click" THEN 1 END) as clicks,
            COUNT(CASE WHEN event_type = "conversion" THEN 1 END) as conversions,
            AVG(CASE WHEN event_type = "conversion" THEN conversion_value END) as avg_conversion_value
        ')->first();
    }

    /**
     * Get real-time events for dashboard
     */
    public static function getRealtimeEvents($minutes = 5)
    {
        return static::where('timestamp', '>=', now()->subMinutes($minutes))
            ->orderBy('timestamp', 'desc')
            ->limit(50)
            ->get();
    }

    /**
     * Get user journey for analytics
     */
    public static function getUserJourney($sessionId, $hours = 24)
    {
        return static::where('session_id', $sessionId)
            ->where('timestamp', '>=', now()->subHours($hours))
            ->orderBy('timestamp')
            ->get();
    }
}
