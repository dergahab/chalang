<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use App\Models\ExportHistory;
use App\Services\ExportService;

class ExportController extends Controller
{
    private ExportService $exportService;

    public function __construct(ExportService $exportService)
    {
        $this->exportService = $exportService;
    }

    public function index()
    {
        $allowedModels = \App\Services\ImportService::getAllowedModels(); // Reuse allowed models for export too
        return view('admin.export.index', compact('allowedModels'));
    }

    /**
     * Master Export - Enterprise Grade with Filter & Field Selection
     */
    public function export(Request $request)
    {
        $modelName = $request->model ?? $request->segment(4);
        $format = strtolower($request->format ?? 'csv');

        // === MASTER: Field Selection ===
        $selectedFields = $request->fields ? explode(',', $request->fields) : [];

        // === MASTER: Filter Conditions ===
        $filters = $request->filters ?? [];
        $filters['model'] = $modelName;

        // Validation
        if (!$modelName) {
            return back()->with('error', 'Model adı tələb olunur');
        }

        if (!in_array($format, ['csv', 'json', 'xlsx'])) {
            return back()->with('error', 'Dəstəklənməyən format: ' . $format);
        }

        try {
            // Get data using service
            $data = $this->exportService->exportData($filters, $selectedFields);

            if ($data->isEmpty()) {
                return back()->with('error', 'Məlumat tapılmadı');
            }

            // Record export history
            $this->recordExportHistory($modelName, $format, $data->count());

            // Generate export file
            $filePath = $this->exportService->generateExportFile($data, $format, $selectedFields);

            return Response::download(storage_path('app/public/' . $filePath))
                ->deleteFileAfterSend(true);

        } catch (\Exception $e) {
            Log::error('Export error: ' . $e->getMessage());
            return back()->with('error', 'Eksport xətası: ' . $e->getMessage());
        }
    }

    /**
     * Stream large exports
     */
    public function streamExport(Request $request)
    {
        $modelName = $request->model;
        $format = strtolower($request->format ?? 'csv');
        $filters = $request->filters ?? [];
        $selectedFields = $request->fields ? explode(',', $request->fields) : [];

        $filters['model'] = $modelName;

        try {
            $data = $this->exportService->exportData($filters, $selectedFields);

            if ($data->isEmpty()) {
                return response()->json(['error' => 'No data found'], 404);
            }

            $filePath = $this->exportService->generateExportFile($data, $format, $selectedFields);

            return response()->download(storage_path('app/public/' . $filePath))
                ->deleteFileAfterSend(true);

        } catch (\Exception $e) {
            Log::error('Stream export error: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Get available fields for a model
     */
    public function getModelFields($model)
    {
        try {
            $fields = $this->exportService->getExportFields($model);

            return response()->json([
                'model' => $model,
                'fields' => $fields,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Record export history
     */
    private function recordExportHistory(string $model, string $format, int $count): void
    {
        try {
            ExportHistory::create([
                'model_type' => $model,
                'format' => $format,
                'total_rows' => $count,
                'user_id' => auth()->id(),
                'completed_at' => now(),
            ]);
        } catch (\Exception $e) {
            Log::warning('Failed to record export history: ' . $e->getMessage());
        }
    }
}