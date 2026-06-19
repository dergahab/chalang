<?php

namespace App\Services;

use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AuditService
{
    /**
     * Models to auto-audit
     */
    protected static array $auditableModels = [
        'Service', 'Blog', 'Portfolio', 'User', 'Role',
        'Tag', 'TeamMember', 'Testimonial', 'Partner',
        'PricingPlan', 'Faq', 'Experiment', 'Banner',
        'Setting', 'Category', 'ContentText', 'Step',
    ];

    /**
     * Excluded routes from auditing
     */
    protected static array $excludedRoutes = [
        'api.health', 'api.heartbeat', 'ignition.*',
    ];

    /**
     * Log an action
     */
    public static function log(string $action, ?string $entityType = null, ?int $entityId = null, array $data = []): ?ActivityLog
    {
        try {
            return ActivityLog::create([
                'user_id' => Auth::id() ?? null,
                'action' => $action,
                'entity_type' => $entityType,
                'entity_id' => $entityId,
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
        } catch (\Exception $e) {
            Log::error('Audit logging failed: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Log model create
     */
    public static function logCreate($model, array $data = []): ?ActivityLog
    {
        return self::log(
            'create',
            get_class($model),
            $model->id ?? null,
            [
                'new_values' => $model->toArray(),
                'description' => self::getModelLabel($model) . ' yaradıldı',
                ...$data,
            ]
        );
    }

    /**
     * Log model update
     */
    public static function logUpdate($model, array $data = []): ?ActivityLog
    {
        return self::log(
            'update',
            get_class($model),
            $model->id ?? null,
            [
                'old_values' => $data['old_values'] ?? null,
                'new_values' => $data['new_values'] ?? $model->toArray(),
                'description' => self::getModelLabel($model) . ' yeniləndi',
                ...$data,
            ]
        );
    }

    /**
     * Log model delete
     */
    public static function logDelete($model, array $data = []): ?ActivityLog
    {
        return self::log(
            'delete',
            get_class($model),
            $model->id ?? null,
            [
                'old_values' => $model->toArray(),
                'description' => self::getModelLabel($model) . ' silindi',
                ...$data,
            ]
        );
    }

    /**
     * Log bulk action
     */
    public static function logBulk(string $action, string $entityType, array $entityIds, array $data = []): ?ActivityLog
    {
        return self::log(
            'bulk_' . $action,
            $entityType,
            null,
            [
                'entity_ids' => $entityIds,
                'count' => count($entityIds),
                'description' => count($entityIds) . ' ədəd ' . self::getModelLabel($entityType) . ' ' . trans("audit.actions.{$action}") ?? $action,
                'metadata' => $data['metadata'] ?? null,
            ]
        );
    }

    /**
     * Log user login
     */
    public static function logLogin(?int $userId = null): ?ActivityLog
    {
        return self::log('login', 'App\\Models\\User', $userId, [
            'description' => 'İstifadəçi daxil oldu',
        ]);
    }

    /**
     * Log user logout
     */
    public static function logLogout(?int $userId = null): ?ActivityLog
    {
        return self::log('logout', 'App\\Models\\User', $userId, [
            'description' => 'İstifadəçi çıxış etdi',
        ]);
    }

    /**
     * Log import action
     */
    public static function logImport(string $entityType, int $importedCount, array $data = []): ?ActivityLog
    {
        return self::log('import', $entityType, null, [
            'count' => $importedCount,
            'description' => "{$importedCount} ədəd {$entityType} import edildi",
            'metadata' => $data,
        ]);
    }

    /**
     * Log export action
     */
    public static function logExport(string $entityType, int $exportedCount, array $data = []): ?ActivityLog
    {
        return self::log('export', $entityType, null, [
            'count' => $exportedCount,
            'description' => "{$exportedCount} ədəd {$entityType} ixrac edildi",
            'metadata' => $data,
        ]);
    }

    /**
     * Get model label
     */
    protected static function getModelLabel($model): string
    {
        $class = is_string($model) ? $model : get_class($model);
        $labels = [
            'App\\Models\\Service' => 'Xidmət',
            'App\\Models\\Blog' => 'Blog',
            'App\\Models\\Portfolio' => 'Portfolio',
            'App\\Models\\User' => 'İstifadəçi',
            'App\\Models\\Role' => 'Rol',
            'App\\Models\\Tag' => 'Tag',
            'App\\Models\\TeamMember' => 'Komanda üzvü',
            'App\\Models\\Testimonial' => 'Rəy',
            'App\\Models\\Partner' => 'Partnyor',
            'App\\Models\\PricingPlan' => 'Qiymət Planı',
            'App\\Models\\Faq' => 'FAQ',
            'App\\Models\\Experiment' => 'Eksperiment',
            'App\\Models\\Banner' => 'Banner',
            'App\\Models\\Pcategory' => 'Kateqoriya',
            'App\\Models\\Bcategory' => 'Blog Kateqoriyası',
        ];

        return $labels[$class] ?? class_basename($class);
    }

    /**
     * Get audit summary for dashboard
     */
    public static function getSummary(int $days = 7): array
    {
        $from = now()->subDays($days);

        $stats = ActivityLog::where('created_at', '>=', $from)
            ->selectRaw('action, COUNT(*) as count')
            ->groupBy('action')
            ->pluck('count', 'action')
            ->toArray();

        $byUser = ActivityLog::where('created_at', '>=', $from)
            ->whereNotNull('user_id')
            ->selectRaw('user_id, COUNT(*) as count')
            ->groupBy('user_id')
            ->orderByDesc('count')
            ->limit(10)
            ->get();

        $failed = ActivityLog::where('created_at', '>=', $from)
            ->where('status', 'failed')
            ->count();

        return [
            'total_actions' => array_sum($stats),
            'by_action' => $stats,
            'by_user' => $byUser,
            'failed_count' => $failed,
            'period_days' => $days,
        ];
    }

    /**
     * Get recent activity
     */
    public static function getRecent(int $limit = 50, ?string $action = null): \Illuminate\Database\Eloquent\Collection
    {
        $query = ActivityLog::with('user')->orderByDesc('created_at');

        if ($action) {
            $query->where('action', $action);
        }

        return $query->limit($limit)->get();
    }

    /**
     * Search logs
     */
    public static function search(array $filters, int $perPage = 50): \Illuminate\Pagination\LengthAwarePaginator
    {
        $query = ActivityLog::with('user');

        if (!empty($filters['user_id'])) {
            $query->where('user_id', $filters['user_id']);
        }

        if (!empty($filters['action'])) {
            $query->where('action', $filters['action']);
        }

        if (!empty($filters['entity_type'])) {
            $query->where('entity_type', $filters['entity_type']);
        }

        if (!empty($filters['from'])) {
            $query->where('created_at', '>=', $filters['from']);
        }

        if (!empty($filters['to'])) {
            $query->where('created_at', '<=', $filters['to']);
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('description', 'like', "%{$filters['search']}%")
                    ->orWhere('route', 'like', "%{$filters['search']}%");
            });
        }

        return $query->orderByDesc('created_at')->paginate($perPage);
    }

    /**
     * Clean old logs
     */
    public static function prune(int $daysToKeep = 90): int
    {
        $cutoff = now()->subDays($daysToKeep);

        return ActivityLog::where('created_at', '<', $cutoff)->delete();
    }

    /**
     * Get entity history
     */
    public static function getEntityHistory(string $entityType, int $entityId): \Illuminate\Database\Eloquent\Collection
    {
        return ActivityLog::where('entity_type', $entityType)
            ->where('entity_id', $entityId)
            ->orderByDesc('created_at')
            ->get();
    }
}