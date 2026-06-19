<?php

namespace App\Models;

use App\Services\AuditService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ScheduledAction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'action',
        'model_type',
        'entity_ids',
        'filters',
        'status',
        'scheduled_at',
        'started_at',
        'completed_at',
        'processed_count',
        'success_count',
        'failed_count',
        'results',
        'error_message',
        'is_recurring',
        'recurring_pattern',
        'next_run_at',
    ];

    protected $casts = [
        'entity_ids' => 'array',
        'filters' => 'array',
        'results' => 'array',
        'scheduled_at' => 'datetime',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        'is_recurring' => 'boolean',
        'next_run_at' => 'datetime',
    ];

    public const STATUS_PENDING = 'pending';
    public const STATUS_RUNNING = 'running';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_FAILED = 'failed';
    public const STATUS_CANCELLED = 'cancelled';

    public const RECURRING_DAILY = 'daily';
    public const RECURRING_WEEKLY = 'weekly';
    public const RECURRING_MONTHLY = 'monthly';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Mark as running
     */
    public function markAsRunning(): void
    {
        $this->update([
            'status' => self::STATUS_RUNNING,
            'started_at' => now(),
        ]);
    }

    /**
     * Mark as completed
     */
    public function markAsCompleted(int $successCount, int $failedCount, array $results = []): void
    {
        $nextRun = null;

        if ($this->is_recurring) {
            $nextRun = $this->calculateNextRun();
        }

        $this->update([
            'status' => self::STATUS_COMPLETED,
            'completed_at' => now(),
            'success_count' => $successCount,
            'failed_count' => $failedCount,
            'results' => $results,
            'next_run_at' => $nextRun,
        ]);
    }

    /**
     * Mark as failed
     */
    public function markAsFailed(string $errorMessage): void
    {
        $this->update([
            'status' => self::STATUS_FAILED,
            'completed_at' => now(),
            'error_message' => $errorMessage,
        ]);
    }

    /**
     * Cancel
     */
    public function cancel(): void
    {
        $this->update([
            'status' => self::STATUS_CANCELLED,
        ]);
    }

    /**
     * Calculate next run time
     */
    protected function calculateNextRun(): ?\Carbon\Carbon
    {
        return match ($this->recurring_pattern) {
            self::RECURRING_DAILY => $this->scheduled_at->addDay(),
            self::RECURRING_WEEKLY => $this->scheduled_at->addWeek(),
            self::RECURRING_MONTHLY => $this->scheduled_at->addMonth(),
            default => null,
        };
    }

    /**
     * Get model label
     */
    public function getModelLabelAttribute(): string
    {
        $labels = [
            'App\\Models\\Service' => 'Xidmətlər',
            'App\\Models\\Blog' => 'Blog yazıları',
            'App\\Models\\Portfolio' => 'Portfolio layihələri',
            'App\\Models\\User' => 'İstifadəçilər',
            'App\\Models\\Tag' => 'Taglər',
            'App\\Models\\TeamMember' => 'Komanda üzvləri',
            'App\\Models\\Testimonial' => 'Rəylər',
            'App\\Models\\Partner' => 'Partnyorlar',
            'App\\Models\\PricingPlan' => 'Qiymət planları',
            'App\\Models\\Faq' => 'FAQ-lər',
        ];

        return $labels[$this->model_type] ?? class_basename($this->model_type);
    }

    /**
     * Scope: Pending actions
     */
    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    /**
     * Scope: Due actions
     */
    public function scopeDue($query)
    {
        return $query->where('status', self::STATUS_PENDING)
            ->where('scheduled_at', '<=', now());
    }
}