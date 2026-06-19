<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\ImportHistory;
use App\Services\ImportService;
use App\Jobs\ProcessImportJob;

class ImportHistoryController extends Controller
{
    /**
     * Display import history
     */
    public function index(Request $request)
    {
        $query = ImportHistory::with('user')->orderBy('created_at', 'desc');

        // Filter by model
        if ($request->model) {
            $query->where('model_type', $request->model);
        }

        // Filter by status
        if ($request->status) {
            $query->where('status', $request->status);
        }

        // Filter by user
        if ($request->user_id) {
            $query->where('user_id', $request->user_id);
        }

        $histories = $query->paginate(20);

        // Stats
        $stats = [
            'total' => ImportHistory::count(),
            'pending' => ImportHistory::where('status', 'pending')->count(),
            'processing' => ImportHistory::where('status', 'processing')->count(),
            'completed' => ImportHistory::where('status', 'completed')->count(),
            'failed' => ImportHistory::where('status', 'failed')->count(),
        ];

        // Models
        $models = ImportHistory::distinct()->pluck('model_type');

        return view('admin.import.history', compact('histories', 'stats', 'models'));
    }

    /**
     * Show import details
     */
    public function show($id)
    {
        $history = ImportHistory::with('user')->findOrFail($id);
        return view('admin.import.show', compact('history'));
    }

/**
     * Advanced Rollback import - supports both COMPLETED and FAILED imports
     */
    public function rollback(Request $request, $id)
    {
        $history = ImportHistory::findOrFail($id);

        if (!$history->canRollback()) {
            return back()->with('error', 'Bu import geri qaytarıla bilməz. Yalnız tamamlanmış və ya uğursuz import-lar geri qaytarıla bilər.');
        }

        $payload = $history->getRollbackPayload();
        $createdIds = $payload['created_ids'] ?? [];
        $updatedSnapshots = $payload['updated_snapshots'] ?? [];
        
        // FAILED import üçün əlavə snapshot
        $failedRowsData = $history->getFailedRowsData();
        
        $deletedCount = 0;
        $restoredCount = 0;
        $failedRestoredCount = 0;

        try {
            DB::transaction(function () use ($history, $createdIds, $updatedSnapshots, $failedRowsData, &$deletedCount, &$restoredCount, &$failedRestoredCount) {
                $modelClass = 'App\\Models\\' . Str::studly($history->model_type);

                // COMPLETED import: yaradılan yazıları sil, yenilənmişləri bərpa et
                if (!empty($createdIds)) {
                    $deletedCount = $modelClass::whereIn('id', $createdIds)->delete();
                }

                foreach ($updatedSnapshots as $recordId => $snapshot) {
                    $record = $modelClass::find($recordId);
                    if ($record && isset($snapshot['before']) && is_array($snapshot['before'])) {
                        $record->fill($snapshot['before']);
                        $record->save();
                        $restoredCount++;
                    }
                }

                // FAILED import: uğursuz sətirləri original vəziyyətinə qaytar
                if (!empty($failedRowsData)) {
                    foreach ($failedRowsData as $failedData) {
                        if (isset($failedData['id'])) {
                            $record = $modelClass::find($failedData['id']);
                            if ($record && isset($failedData['original_data'])) {
                                $record->fill($failedData['original_data']);
                                $record->save();
                                $failedRestoredCount++;
                            }
                        }
                    }
                }

                $history->update([
                    'status' => ImportHistory::STATUS_ROLLBACKED,
                    'meta' => array_merge($history->meta ?? [], [
                        'rollback_created' => $deletedCount,
                        'rollback_restored' => $restoredCount,
                        'rollback_failed_restored' => $failedRestoredCount,
                        'rollback_note' => $request->note ?? null,
                        'rollback_at' => now()->toDateTimeString(),
                    ]),
                ]);
            });

            $message = "İmport geri qaytarıldı";
            if ($deletedCount > 0) $message .= ": {$deletedCount} yaradılan yazı silindi";
            if ($restoredCount > 0) $message .= ", {$restoredCount} yenilənmiş yazı bərpa edildi";
            if ($failedRestoredCount > 0) $message .= ", {$failedRestoredCount} uğursuz yazı bərpa edildi";

            return back()->with('success', $message);
        } catch (\Exception $e) {
            return back()->with('error', 'Rollback xətası: ' . $e->getMessage());
        }
    }

    /**
     * Delete history
     */
    public function destroy($id)
    {
        $history = ImportHistory::findOrFail($id);
        $history->delete();

        return back()->with('success', 'History silindi');
    }

    /**
     * Retry failed import
     */
    public function retry($id)
    {
        $history = ImportHistory::findOrFail($id);

        if ($history->status !== ImportHistory::STATUS_FAILED) {
            return back()->with('error', 'Yalnız failed import Retry edilə bilər');
        }

        try {
            $meta = $history->meta ?? [];
            if (empty($meta['temp_file_path']) || !Storage::exists($meta['temp_file_path'])) {
                return back()->with('error', 'Retry üçün import faylı tapılmadı');
            }

            $allData = app(ImportService::class)->parseFileFromPath($meta['temp_file_path']);

            $history->update([
                'status' => ImportHistory::STATUS_PENDING,
                'failed_rows' => 0,
                'created_rows' => 0,
                'updated_rows' => 0,
                'completed_at' => null,
                'errors' => null,
                'meta' => array_merge($meta, [
                    'created_ids' => [],
                    'updated_snapshots' => [],
                ]),
            ]);

            ProcessImportJob::dispatch(
                $allData,
                $history->model_type,
                $meta['mapping'] ?? [],
                $history->id
            )->onQueue('imports');

            return back()->with('success', 'İmport retry üçün yenidən kuyriya edildi');
        } catch (\Exception $e) {
            return back()->with('error', 'Retry xətası: ' . $e->getMessage());
        }
    }

    /**
     * Get history stats API
     */
    public function stats()
    {
        return response()->json([
            'total' => ImportHistory::count(),
            'by_model' => ImportHistory::selectRaw('model_type, COUNT(*) as count, SUM(total_rows) as total_rows')
                ->groupBy('model_type')->get(),
            'by_status' => ImportHistory::selectRaw('status, COUNT(*) as count')
                ->groupBy('status')->get(),
        ]);
    }
}