<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'action',
        'entity_type',
        'entity_id',
        'old_values',
        'new_values',
        'description',
        'ip_address',
        'user_agent',
        'session_id',
        'method',
        'route',
        'duration_ms',
        'status',
        'error_message',
        'metadata',
    ];

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
        'metadata' => 'array',
    ];

    /**
     * Action types
     */
    public const ACTIONS = [
        'create' => 'Yaradılıb',
        'update' => 'Yenilənib',
        'delete' => 'Silinib',
        'restore' => 'Bərpa edilib',
        'export' => 'İxrac edilib',
        'import' => 'İmport edilib',
        'login' => 'Daxil olub',
        'logout' => 'Çıxış edib',
        'bulk_create' => 'Toplu yaradılıb',
        'bulk_update' => 'Toplu yenilənib',
        'bulk_delete' => 'Toplu silinib',
        'toggle' => 'Status dəyişib',
        'duplicate' => 'Klonlanıb',
    ];

    /**
     * Entity types mapping
     */
    public static function getEntityLabel(string $entityType): string
    {
        $labels = [
            'App\\Models\\Service' => 'Xidmət',
            'App\\Models\\Blog' => 'Blog',
            'App\\Models\\Portfolio' => 'Portfolio',
            'App\\Models\\User' => 'İstifadəçi',
            'App\\Models\\Role' => 'Rol',
            'App\\Models\\Setting' => 'Tənzimləmə',
            'App\\Models\\Banner' => 'Banner',
            'App\\Models\\Tag' => 'Tag',
            'App\\Models\\TeamMember' => 'Komanda üzvü',
            'App\\Models\\Testimonial' => 'Rəy',
            'App\\Models\\Partner' => 'Partnyor',
            'App\\Models\\PricingPlan' => 'Qiymət Planı',
            'App\\Models\\Faq' => 'FAQ',
            'App\\Models\\Experiment' => 'Eksperiment',
        ];

        return $labels[$entityType] ?? class_basename($entityType);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope: Filter by entity
     */
    public function scopeForEntity($query, string $entityType, int $entityId)
    {
        return $query->where('entity_type', $entityType)->where('entity_id', $entityId);
    }

    /**
     * Scope: Filter by user
     */
    public function scopeForUser($query, int $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope: Filter by action
     */
    public function scopeWithAction($query, string $action)
    {
        return $query->where('action', $action);
    }

    /**
     * Scope: Filter by date range
     */
    public function scopeInDateRange($query, string $from, string $to)
    {
        return $query->whereBetween('created_at', [$from, $to]);
    }

    /**
     * Scope: Failed actions
     */
    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }

    /**
     * Get formatted description
     */
    public function getFormattedDescriptionAttribute(): string
    {
        $entityLabel = self::getEntityLabel($this->entity_type ?? '');
        $actionLabel = self::ACTIONS[$this->action] ?? $this->action;

        if ($this->entity_type && $this->entity_id) {
            return "{$entityLabel} #{$this->entity_id} {$actionLabel}";
        }

        return $actionLabel;
    }

    /**
     * Static: Quick log helper
     */
    public static function log(array $data): self
    {
        return static::create([
            'user_id' => auth()->id() ?? null,
            'action' => $data['action'],
            'entity_type' => $data['entity_type'] ?? null,
            'entity_id' => $data['entity_id'] ?? null,
            'old_values' => $data['old_values'] ?? null,
            'new_values' => $data['new_values'] ?? null,
            'description' => $data['description'] ?? null,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'session_id' => session()->getId(),
            'method' => request()->method(),
            'route' => request()->route()?->getName(),
            'duration_ms' => $data['duration_ms'] ?? null,
            'status' => $data['status'] ?? 'success',
            'error_message' => $data['error_message'] ?? null,
            'metadata' => $data['metadata'] ?? null,
        ]);
    }
}