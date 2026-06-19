<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Models\ImportHistory;
use App\Services\ImportService;

class ProcessImportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
    public int $timeout = 3600; // 1 hour

    public function __construct(
        public array $data,
        public string $modelKey,
        public array $mapping,
        public int $historyId
    ) {
        $this->onQueue('imports');
    }

public function handle(): void
    {
        $history = ImportHistory::find($this->historyId);

        if (!$history) {
            Log::error('Import history not found: ' . $this->historyId);
            return;
        }

        $history->update(['status' => 'processing']);

        $importService = app(ImportService::class);
        $processed = 0;
        $created = 0;
        $updated = 0;
        $failed = 0;
        $errors = [];
        $meta = $history->meta ?? [];
        $meta['created_ids'] = $meta['created_ids'] ?? [];
        $meta['updated_snapshots'] = $meta['updated_snapshots'] ?? [];
        // Store original data for rollback
        $meta['original_data'] = $meta['original_data'] ?? [];

        try {
            $batches = array_chunk($this->data, ImportService::BATCH_SIZE);

            foreach ($batches as $batch) {
                // Backup before processing (for rollback capability)
                $this->backupBeforeBatch($batch, $this->modelKey, $meta);
                
                $result = $importService->processImportBatch($batch, $this->modelKey, $this->mapping);

                $created += $result['created'] ?? 0;
                $updated += $result['updated'] ?? 0;
                $failed += $result['failed'] ?? 0;
                $processed += count($batch);

                if (!empty($result['errors'])) {
                    $errors = array_merge($errors, $result['errors']);
                }

                $meta['created_ids'] = array_unique(array_merge($meta['created_ids'], $result['created_ids'] ?? []));
                $meta['updated_snapshots'] = array_merge($meta['updated_snapshots'], $result['updated_snapshots'] ?? []);

                $history->update([
                    'created_rows' => $created,
                    'updated_rows' => $updated,
                    'failed_rows' => $failed,
                    'meta' => $meta,
                ]);
            }

            $history->update([
                'status' => 'completed',
                'errors' => $errors,
                'meta' => $meta,
                'completed_at' => now(),
            ]);

            if (!empty($meta['temp_file_path']) && Storage::exists($meta['temp_file_path'])) {
                Storage::delete($meta['temp_file_path']);
            }

            $this->sendNotification($history);
        } catch (\Exception $e) {
            Log::error('ProcessImportJob error: ' . $e->getMessage());
            
            // Advanced Rollback: Restore data on failure
            $rollbackResult = $this->performRollback($meta, $this->modelKey);
            
            $history->update([
                'status' => 'failed',
                'errors' => array_merge($errors, [
                    $e->getMessage(),
                    $rollbackResult['message'] ?? ''
                ]),
                'meta' => $meta,
                'completed_at' => now(),
            ]);
        }
    }

    /**
     * Backup records before batch processing for rollback
     */
    private function backupBeforeBatch(array $batch, string $modelKey, array &$meta): void
    {
        $modelClass = 'App\\Models\\' . ucfirst($modelKey);
        if (!class_exists($modelClass)) {
            return;
        }

        $idsToBackup = [];
        foreach ($batch as $row) {
            if (isset($row['id'])) {
                $idsToBackup[] = $row['id'];
            }
        }

        if (empty($idsToBackup)) {
            return;
        }

        $records = $modelClass::whereIn('id', $idsToBackup)->get();
        foreach ($records as $record) {
            $meta['original_data'][$record->id] = $record->getOriginal();
        }
    }

    /**
     * Perform rollback on import failure
     */
    private function performRollback(array $meta, string $modelKey): array
    {
        $modelClass = 'App\\Models\\' . ucfirst($modelKey);
        if (!class_exists($modelClass) || empty($meta['original_data'])) {
            return ['success' => false, 'message' => 'No original data to rollback'];
        }

        try {
            $restored = 0;
            foreach ($meta['original_data'] as $id => $originalData) {
                $record = $modelClass::find($id);
                if ($record) {
                    // Restore original values
                    $record->update($originalData);
                    $restored++;
                }
            }

            Log::info("Advanced Rollback: Restored {$restored} records for {$modelKey}");
            return ['success' => true, 'message' => "{$restored} record geri yükləndi", 'restored' => $restored];
        } catch (\Exception $e) {
            Log::error('Rollback failed: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Rollback xətası: ' . $e->getMessage()];
        }
    }

    private function sendNotification(ImportHistory $history): void
    {
        // TODO: Implement notification logic
    }

    public function failed(\Throwable $exception): void
    {
        $history = ImportHistory::find($this->historyId);

        if ($history) {
            $history->markFailed($exception->getMessage());
        }

        Log::error('ProcessImportJob failed: ' . $exception->getMessage());
    }
}
