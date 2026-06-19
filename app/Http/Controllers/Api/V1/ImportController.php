<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Services\ImportService;
use App\Models\ImportHistory;

class ImportController extends Controller
{
    private ImportService $importService;

    public function __construct(ImportService $importService)
    {
        $this->importService = $importService;
    }

    /**
     * GET /api/v1/import/models
     * Available models for import
     */
    public function models(): JsonResponse
    {
        $models = ImportService::getPreConfiguredTemplates();
        
        return response()->json([
            'success' => true,
            'data' => collect($models)->map(function($template, $key) {
                return [
                    'key' => $key,
                    'name' => $template['name'],
                    'description' => $template['description'],
                    'fields_count' => count($template['fields']),
                ];
            })->values(),
        ]);
    }

    /**
     * GET /api/v1/import/fields/{model}
     * Get field definitions for a model
     */
    public function fields(string $model): JsonResponse
    {
        if (!ImportService::isModelAllowed($model)) {
            return response()->json([
                'success' => false,
                'message' => 'Model not allowed for import',
            ], 400);
        }

        $fields = $this->importService->getImportFieldDefinitions($model);
        
        return response()->json([
            'success' => true,
            'model' => $model,
            'data' => $fields,
        ]);
    }

    /**
     * POST /api/v1/import/template/{model}
     * Generate/download template for a model
     */
    public function template(Request $request, string $model): JsonResponse
    {
        if (!ImportService::isModelAllowed($model)) {
            return response()->json([
                'success' => false,
                'message' => 'Model not allowed for import',
            ], 400);
        }

        $format = $request->input('format', 'csv');
        if (!in_array($format, ['csv', 'json'])) {
            return response()->json([
                'success' => false,
                'message' => 'Unsupported format. Use csv or json.',
            ], 400);
        }

        try {
            $path = $this->importService->generatePreConfiguredTemplate($model, $format);
            
            if (!$path) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to generate template',
                ], 500);
            }

            return response()->json([
                'success' => true,
                'message' => 'Template generated successfully',
                'download_url' => asset('storage/' . $path),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * POST /api/v1/import
     * Process import (simple mode)
     */
    public function import(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'model' => 'required|string',
            'data' => 'required|array',
            'mapping' => 'nullable|array',
            'mode' => 'nullable|in:merge,skip',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        $modelKey = $request->model;
        
        if (!ImportService::isModelAllowed($modelKey)) {
            return response()->json([
                'success' => false,
                'message' => 'Model not allowed for import',
            ], 400);
        }

        try {
            $data = $request->input('data', []);
            $mapping = $request->input('mapping', []);
            $mode = $request->input('mode', 'merge');

            // Process first batch only (for API simplicity)
            $batch = array_slice($data, 0, ImportService::BATCH_SIZE);
            $result = $this->importService->processImportBatch($batch, $modelKey, $mapping);

            return response()->json([
                'success' => true,
                'message' => 'Import processed',
                'data' => [
                    'created' => $result['created'],
                    'updated' => $result['updated'],
                    'failed' => $result['failed'],
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Import failed: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * GET /api/v1/import/history
     * Get import history
     */
    public function history(Request $request): JsonResponse
    {
        $query = ImportHistory::with('user')->orderBy('created_at', 'desc');

        if ($request->model) {
            $query->where('model_type', $request->model);
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $histories = $query->paginate($request->per_page ?? 20);

        return response()->json([
            'success' => true,
            'data' => $histories,
        ]);
    }

    /**
     * GET /api/v1/import/history/{id}
     * Get import history details
     */
    public function historyShow(int $id): JsonResponse
    {
        $history = ImportHistory::with('user')->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $history->id,
                'model_type' => $history->model_type,
                'file_name' => $history->file_name,
                'total_rows' => $history->total_rows,
                'created_rows' => $history->created_rows,
                'updated_rows' => $history->updated_rows,
                'failed_rows' => $history->failed_rows,
                'status' => $history->status,
                'success_rate' => $history->success_rate,
                'errors' => $history->errors,
                'created_at' => $history->created_at,
                'completed_at' => $history->completed_at,
            ],
        ]);
    }

    /**
     * POST /api/v1/import/history/{id}/rollback
     * Rollback import
     */
    public function rollback(int $id): JsonResponse
    {
        $history = ImportHistory::findOrFail($id);

        if (!$history->canRollback()) {
            return response()->json([
                'success' => false,
                'message' => 'This import cannot be rolled back',
            ], 400);
        }

        try {
            // Note: Full rollback via API should be implemented carefully
            // For now, return a warning
            return response()->json([
                'success' => false,
                'message' => 'Rollback via API is not fully implemented yet. Please use admin panel.',
            ], 501);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
