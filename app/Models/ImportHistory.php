<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ImportHistory extends Model
{
    protected $table = 'import_histories';

    protected $fillable = [
        'model_type',
        'file_name',
        'total_rows',
        'created_rows',
        'updated_rows',
        'failed_rows',
        'status',
        'errors',
        'user_id',
        'ip_address',
        'completed_at',
        'meta',
    ];

    protected $casts = [
        'completed_at' => 'datetime',
        'meta' => 'array',
        'errors' => 'array',
        'total_rows' => 'integer',
        'created_rows' => 'integer',
        'updated_rows' => 'integer',
        'failed_rows' => 'integer',
    ];

    // Status constants
    const STATUS_PENDING = 'pending';
    const STATUS_PROCESSING = 'processing';
    const STATUS_COMPLETED = 'completed';
    const STATUS_FAILED = 'failed';
    const STATUS_ROLLBACKED = 'rolled_back';

    /**
     * User relationship
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get success rate
     */
    public function getSuccessRateAttribute(): int
    {
        if ($this->total_rows === 0) {
            return 0;
        }
        $success = $this->created_rows + $this->updated_rows;
        return round(($success / $this->total_rows) * 100);
    }

    /**
     * Mark as completed
     */
    public function markCompleted(int $created = 0, int $updated = 0, int $failed = 0): void
    {
        $this->update([
            'status' => self::STATUS_COMPLETED,
            'created_rows' => $created,
            'updated_rows' => $updated,
            'failed_rows' => $failed,
            'completed_at' => now(),
        ]);
    }

    /**
     * Mark as failed
     */
    public function markFailed(string $errors = ''): void
    {
        $this->update([
            'status' => self::STATUS_FAILED,
            'errors' => $errors,
            'completed_at' => now(),
        ]);
    }

    /**
     * Mark as processing
     */
    public function markProcessing(): void
    {
        $this->update([
            'status' => self::STATUS_PROCESSING,
        ]);
    }

    public function updateMeta(array $meta): void
    {
        $this->update([
            'meta' => array_merge($this->meta ?? [], $meta),
        ]);
    }

    public function getRollbackPayload(): array
    {
        return [
            'created_ids' => $this->meta['created_ids'] ?? [],
            'updated_snapshots' => $this->meta['updated_snapshots'] ?? [],
        ];
    }

public function canRollback(): bool
    {
        // Advanced Rollback: Hem COMPLETED hem de FAILED import-lar geri qaytarila bilir
        return in_array($this->status, [self::STATUS_COMPLETED, self::STATUS_FAILED]);
    }

    /**
     * Check if import can be retried
     */
    public function canRetry(): bool
    {
        return in_array($this->status, [self::STATUS_FAILED, self::STATUS_ROLLBACKED]);
    }

    /**
     * Get failed rows data for retry/rollback
     */
    public function getFailedRowsData(): array
    {
        return $this->meta['failed_rows_data'] ?? [];
    }

    /**
     * Store snapshot for rollback (FAILED import)
     */
    public function storeFailedSnapshot(array $failedRowsData): void
    {
        $this->update([
            'meta' => array_merge($this->meta ?? [], [
                'failed_rows_data' => $failedRowsData,
                'failed_at' => now()->toDateTimeString(),
            ]),
        ]);
    }

    /**
     * Scope for user
     */
    public function scopeForUser($query, int $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope for model
     */
    public function scopeForModel($query, string $modelType)
    {
        return $query->where('model_type', $modelType);
    }

    /**
     * Scope pending
     */
    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }
}