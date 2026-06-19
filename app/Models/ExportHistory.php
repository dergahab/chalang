<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExportHistory extends Model
{
    protected $table = 'export_histories';

    protected $fillable = [
        'model_type',
        'file_name',
        'format',
        'total_rows',
        'status',
        'user_id',
        'ip_address',
        'completed_at',
        'meta',
    ];

    protected $casts = [
        'completed_at' => 'datetime',
        'meta' => 'array',
        'total_rows' => 'integer',
    ];

    /**
     * User relationship
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
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
}