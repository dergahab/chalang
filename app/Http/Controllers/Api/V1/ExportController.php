<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
use App\Services\ExportService;
use App\Models\ExportHistory;

class ExportController extends Controller
{
    private ExportService $exportService;

    public function __construct(ExportService $exportService)
    {
        $this->exportService = $exportService;
    }

    /**
     * GET /api/v1/export/models
     * Available models for export
     */
    public function models(): JsonResponse
    {
        $models = ExportService::getAllowedModels();
        
        return response()->json([
            'success' => true,
            'data' => collect($models)->map(function($permission, $key) {
                return [
                    'key' => $key,
                    'name' => \Illuminate\Support\Str::title(str_replace('-', ' ', $key)),
                ];
            })->values(),
        ]);
    }

    /**
     * GET /api/v1/export/fields/{model}
     * Get available fields for export
     */
    public function fields(string $model): JsonResponse
    {
        if (!ExportService::isModelAllowed($model)) {
            return response()->json([
                'success' => false,
                'message' => 'Model not allowed for export',
            ], 400);
        }

        $fields = $this->exportService->getExportFields($model);
        
        return response()->json([
            'success' => true,
            'model' => $model,
            'data' => $fields,
        ]);
    }

    /**
     * POST /api/v1/export
     * Run export
     */
    public function export(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'model' => 'required|string',
            'format' => 'nullable|in:csv,json,xlsx',
            'fields' => 'nullable|array',
            'filters' => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        $modelKey = $request->model;
        
        if (!ExportService::isModelAllowed($modelKey)) {
            return response()->json([
                'success' => false,
                'message' => 'Model not allowed for export',
            ], 400);
        }

        try {
            $format = $request->input('format', 'csv');
            $fields = $request->input('fields', []);
            $filters = $request->input('filters', []);
            $filters['model'] = $modelKey;

            // Get data
            $data = $this->exportService->exportData($filters, $fields);

            if ($data->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No data found for export',
                ], 404);
            }

            // Generate file
            $filePath = $this->exportService->generateExportFile($data, $format, $fields);

            // Record history
            ExportHistory::create([
                'model_type' => $modelKey,
                'format' => $format,
                'total_rows' => $data->count(),
                'user_id' => Auth::id() ?? 1,
                'completed_at' => now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Export completed',
                'data' => [
                    'download_url' => asset('storage/' . $filePath),
                    'total_rows' => $data->count(),
                    'format' => $format,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Export failed: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * GET /api/v1/export/history
     * Get export history
     */
    public function history(Request $request): JsonResponse
    {
        $query = ExportHistory::with('user')->orderBy('created_at', 'desc');

        if ($request->model) {
            $query->where('model_type', $request->model);
        }

        $histories = $query->paginate($request->per_page ?? 20);

        return response()->json([
            'success' => true,
            'data' => $histories,
        ]);
    }

    /**
     * GET /api/v1/export/history/{id}
     * Get export history details
     */
    public function historyShow(int $id): JsonResponse
    {
        $history = ExportHistory::with('user')->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $history->id,
                'model_type' => $history->model_type,
                'format' => $history->format,
                'total_rows' => $history->total_rows,
                'status' => $history->status,
                'created_at' => $history->created_at,
                'completed_at' => $history->completed_at,
            ],
        ]);
    }

    /**
     * GET /api/v1/export/stats
     * Get export statistics
     */
    public function stats(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => [
                'total_exports' => ExportHistory::count(),
                'by_model' => ExportHistory::selectRaw('model_type, COUNT(*) as count, SUM(total_rows) as total_rows')
                    ->groupBy('model_type')->get(),
            ],
        ]);
    }
}
