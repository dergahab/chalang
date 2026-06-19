<?php

namespace App\Services;

use App\Models\ScheduledAction;
use Illuminate\Support\Facades\DB;

class ScheduledActionService
{
    /**
     * Create a new scheduled action
     */
    public static function schedule(
        string $name,
        string $action,
        string $modelType,
        array $entityIds,
        string $scheduledAt,
        array $filters = [],
        bool $isRecurring = false,
        ?string $recurringPattern = null
    ): ScheduledAction {
        return ScheduledAction::create([
            'user_id' => auth()->id(),
            'name' => $name,
            'action' => $action,
            'model_type' => $modelType,
            'entity_ids' => $entityIds,
            'filters' => $filters,
            'scheduled_at' => $scheduledAt,
            'is_recurring' => $isRecurring,
            'recurring_pattern' => $recurringPattern,
        ]);
    }

    /**
     * Execute a scheduled action
     */
    public static function execute(ScheduledAction $scheduledAction): array
    {
        $scheduledAction->markAsRunning();

        $successCount = 0;
        $failedCount = 0;
        $results = [];

        try {
            $modelType = $scheduledAction->model_type;
            $action = $scheduledAction->action;
            $entityIds = $scheduledAction->entity_ids ?? [];

            // Get model query
            $query = $modelType::query();

            // Apply filters if specified
            if (!empty($scheduledAction->filters)) {
                foreach ($scheduledAction->filters as $field => $value) {
                    $query->where($field, $value);
                }
            }

            // Filter by entity IDs if specified
            if (!empty($entityIds)) {
                $query->whereIn('id', $entityIds);
            }

            $entities = $query->get();

            foreach ($entities as $entity) {
                try {
                    $result = match ($action) {
                        'bulk_delete' => $entity->delete(),
                        'bulk_activate' => $entity->update(['is_active' => 1]),
                        'bulk_deactivate' => $entity->update(['is_active' => 0]),
                        'bulk_toggle_featured' => $entity->update(['is_featured' => !$entity->is_featured]),
                        default => false,
                    };

                    if ($result) {
                        $successCount++;

                        // Audit log
                        AuditService::log($action, $modelType, $entity->id, [
                            'scheduled_action_id' => $scheduledAction->id,
                        ]);
                    } else {
                        $failedCount++;
                    }
                } catch (\Exception $e) {
                    $failedCount++;
                    $results['errors'][] = [
                        'entity_id' => $entity->id,
                        'error' => $e->getMessage(),
                    ];
                }
            }

            $scheduledAction->markAsCompleted($successCount, $failedCount, $results);

            return [
                'success' => true,
                'processed' => $entities->count(),
                'succeeded' => $successCount,
                'failed' => $failedCount,
            ];
        } catch (\Exception $e) {
            $scheduledAction->markAsFailed($e->getMessage());

            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Process all due actions
     */
    public static function processDueActions(): array
    {
        $dueActions = ScheduledAction::due()->get();
        $processed = 0;

        foreach ($dueActions as $action) {
            self::execute($action);
            $processed++;
        }

        return [
            'processed' => $processed,
            'timestamp' => now()->toIso8601String(),
        ];
    }

    /**
     * Cancel a scheduled action
     */
    public static function cancel(int $id): bool
    {
        $action = ScheduledAction::find($id);

        if (!$action || $action->status !== ScheduledAction::STATUS_PENDING) {
            return false;
        }

        $action->cancel();

        return true;
    }

    /**
     * Get scheduled actions for a user
     */
    public static function getUserScheduled(int $userId): \Illuminate\Database\Eloquent\Collection
    {
        return ScheduledAction::where('user_id', $userId)
            ->orderBy('scheduled_at')
            ->get();
    }

    /**
     * Get upcoming actions
     */
    public static function getUpcoming(int $limit = 10): \Illuminate\Database\Eloquent\Collection
    {
        return ScheduledAction::where('status', ScheduledAction::STATUS_PENDING)
            ->orderBy('scheduled_at')
            ->limit($limit)
            ->get();
    }
}