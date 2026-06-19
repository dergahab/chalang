<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExportSchedule extends Model
{
    protected $table = 'export_schedules';

    protected $fillable = [
        'model_type',
        'format',
        'frequency',
        'filters',
        'email_to',
        'last_run_at',
        'next_run_at',
        'is_active',
        'user_id',
        'status',
        'last_file_name',
        'error_message',
    ];

    protected $casts = [
        'filters' => 'array',
        'is_active' => 'boolean',
        'last_run_at' => 'datetime',
        'next_run_at' => 'datetime',
    ];

    // Frequency constants
    const FREQUENCY_DAILY = 'daily';
    const FREQUENCY_WEEKLY = 'weekly';
    const FREQUENCY_MONTHLY = 'monthly';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get frequency options
     */
    public static function getFrequencyOptions(): array
    {
        return [
            self::FREQUENCY_DAILY => 'Günlük',
            self::FREQUENCY_WEEKLY => 'Həftəlik',
            self::FREQUENCY_MONTHLY => 'Aylıq',
        ];
    }

    /**
     * Calculate next run time
     */
    public function calculateNextRun(): \Carbon\Carbon
    {
        $now = now();
        
        switch ($this->frequency) {
            case self::FREQUENCY_DAILY:
                return $now->addDay()->setTime(0, 0, 0);
            case self::FREQUENCY_WEEKLY:
                return $now->addWeek()->startOfWeek()->setTime(0, 0, 0);
            case self::FREQUENCY_MONTHLY:
                return $now->addMonth()->startOfMonth()->setTime(0, 0, 0);
            default:
                return $now->addDay();
        }
    }

    /**
     * Check if should run now
     */
    public function shouldRun(): bool
    {
        if (!$this->is_active) {
            return false;
        }

        if (!$this->next_run_at) {
            return true;
        }

        return now()->gte($this->next_run_at);
    }

    /**
     * Mark as running
     */
    public function markAsRunning(): void
    {
        $this->update(['status' => 'running']);
    }

    /**
     * Mark as completed
     */
    public function markAsCompleted(string $fileName): void
    {
        $this->update([
            'status' => 'completed',
            'last_run_at' => now(),
            'next_run_at' => $this->calculateNextRun(),
            'last_file_name' => $fileName,
            'error_message' => null,
        ]);
    }

    /**
     * Mark as failed
     */
    public function markAsFailed(string $error): void
    {
        $this->update([
            'status' => 'failed',
            'error_message' => $error,
        ]);
    }

    /**
     * Scope active
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}