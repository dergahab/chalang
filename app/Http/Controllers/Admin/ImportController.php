<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Models\ImportHistory;
use App\Jobs\ProcessImportJob;
use App\Services\ImportService;

class ImportController extends Controller
{
    private ImportService $importService;

    public function __construct(ImportService $importService)
    {
        $this->importService = $importService;
    }

    public static function allowedModelKeys(): array
    {
        return array_keys(ImportService::getAllowedModels());
    }

    public function index()
    {
        $allowedModels = ImportService::getAllowedModels();

        return view('admin.import.index', compact('allowedModels'));
    }

    public function preview(Request $request, $model)
    {
        $modelKey = Str::kebab($model);

        if (!ImportService::isModelAllowed($modelKey)) {
            abort(403, 'Model not allowed for import');
        }

        if ($request->isMethod('get')) {
            return redirect()->route('admin.import.index')->with('error', 'Sessiya bitib, zəhmət olmasa faylı yenidən seçin.');
        }

        $request->validate([
            'file' => 'required|file|mimes:csv,txt,xlsx|max:' . ImportService::MAX_FILE_SIZE,
        ]);

try {
            $file = $request->file('file');
            // Preserve original extension in stored filename
            $originalName = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $filename = $originalName;
            $path = $file->storeAs('temp-imports', $filename);

            $allData = $this->importService->parseUploadedFile($file);
            $data = array_slice($allData, 0, ImportService::PREVIEW_ROWS);
            $headers = !empty($data) ? array_keys($data[0]) : [];
            $availableFields = $this->importService->getImportFieldDefinitions($modelKey);
            $translatedAttributes = $this->importService->getTranslatedAttributes($modelKey);
            $format = strtolower($file->getClientOriginalExtension());
            $batchSize = ImportService::BATCH_SIZE;
            $totalRows = count($allData);

            $previewRows = $data;
            $model = $modelKey;
            $filePath = $path;

            return view('admin.import.preview', compact(
                'previewRows',
                'headers',
                'availableFields',
                'translatedAttributes',
                'model',
                'filePath',
                'path',
                'format',
                'totalRows',
                'batchSize'
            ));
        } catch (\Exception $e) {
            Log::error('Import preview failed: ' . $e->getMessage());
            return back()->with('error', 'Failed to process file: ' . $e->getMessage());
        }
    }

    public function import(Request $request, $model)
    {
        $modelKey = Str::kebab($model);

        if (!ImportService::isModelAllowed($modelKey)) {
            abort(403, 'Model not allowed for import');
        }

        $request->validate([
            'file_path' => 'required|string',
            'mapping' => 'required|array',
            'mapping.*' => 'nullable|string',
            'import_mode' => 'required|in:merge,skip',
            'selected_rows' => 'nullable|array',
            'selected_rows.*' => 'nullable|integer',
        ]);

        try {
            $filePath = storage_path('app/' . $request->file_path);

            if (!file_exists($filePath)) {
                return back()->with('error', 'File not found. Please retry upload.');
            }

            $file = new \Illuminate\Http\UploadedFile($filePath, basename($filePath), null, null, true);
            $allData = $this->importService->parseUploadedFile($file);

            if (!empty($request->selected_rows) && is_array($request->selected_rows)) {
                $selectedRows = [];
                foreach ($request->selected_rows as $rowIndex) {
                    $offset = max(0, intval($rowIndex) - 1);
                    if (isset($allData[$offset])) {
                        $selectedRows[] = $allData[$offset];
                    }
                }
                if (!empty($selectedRows)) {
                    $allData = $selectedRows;
                }
            }

            $history = ImportHistory::create([
                'model_type' => $modelKey,
                'file_name' => basename($filePath),
                'total_rows' => count($allData),
                'user_id' => Auth::id(),
                'status' => 'queued',
                'meta' => [
                    'temp_file_path' => $request->file_path,
                    'mapping' => $request->mapping,
                    'import_mode' => $request->import_mode,
                    'selected_rows' => $request->selected_rows ?: [],
                    'format' => $request->format ?? null,
                ],
            ]);

            ProcessImportJob::dispatch(
                $allData,
                $modelKey,
                $request->mapping,
                $history->id
            )->onQueue('imports');

            return redirect()->route('admin.import.progress', $history->id);
        } catch (\Exception $e) {
            Log::error('Import queue failed: ' . $e->getMessage());
            return back()->with('error', 'Import queue failed: ' . $e->getMessage());
        }
    }

    public function progress($historyId)
    {
        $history = ImportHistory::findOrFail($historyId);

        return view('admin.import.progress', compact('historyId'));
    }

    public function status($historyId)
    {
        $history = ImportHistory::with('user')->findOrFail($historyId);

        $processed = ($history->created_rows ?? 0) + ($history->updated_rows ?? 0) + ($history->failed_rows ?? 0);
        $progress = 0;
        if ($history->total_rows > 0) {
            $progress = round(($processed / $history->total_rows) * 100, 2);
        }

        $response = [
            'id' => $history->id,
            'status' => $history->status,
            'progress' => $progress,
            'processed' => $processed,
            'total' => $history->total_rows,
            'created' => $history->created_rows ?? 0,
            'updated' => $history->updated_rows ?? 0,
            'failed' => $history->failed_rows ?? 0,
            'model' => $history->model_type,
            'file_name' => $history->file_name,
            'user' => $history->user ? $history->user->name : 'Unknown',
            'created_at' => $history->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $history->updated_at->format('Y-m-d H:i:s'),
            'errors' => $history->errors ?? [],
            'is_completed' => in_array($history->status, ['completed', 'failed']),
            'duration' => $history->created_at->diffInSeconds($history->updated_at),
        ];

        if ($history->status === 'processing' && $processed > 0) {
            $elapsed = now()->diffInSeconds($history->created_at);
            $estimatedTotal = ($elapsed / $processed) * $history->total_rows;
            $remaining = max(0, $estimatedTotal - $elapsed);
            $response['estimated_remaining_seconds'] = round($remaining);
        }

        return response()->json($response);
    }

    public function getModelFields($model)
    {
        $modelKey = Str::kebab($model);

        if (!ImportService::isModelAllowed($modelKey)) {
            abort(403, 'Model not allowed for import');
        }

        return response()->json([
            'fields' => $this->importService->getImportFieldDefinitions($modelKey),
        ]);
    }

    public function downloadTemplate($model, $format)
    {
        if (class_exists('\Barryvdh\Debugbar\Facades\Debugbar')) {
            \Barryvdh\Debugbar\Facades\Debugbar::disable();
        }

        $modelKey = Str::kebab($model);

        if (!ImportService::isModelAllowed($modelKey)) {
            abort(403, 'Model not allowed for import');
        }

        $format = strtolower($format ?? 'csv');
        if (!in_array($format, ['csv', 'json', 'xlsx'])) {
            abort(400, 'Unsupported template format');
        }

        // Prefer pre-configured templates with samples if available
        $tempPath = $this->importService->generatePreConfiguredTemplate($modelKey, $format);
        
        // Fallback to dynamic generation if no pre-configured template exists
        if (!$tempPath) {
            $tempPath = $this->importService->generateImportTemplate($modelKey, $format);
        }

        if (!Storage::disk('public')->exists($tempPath)) {
            abort(404, 'Şablon faylı tapılmadı.');
        }

        $downloadName = sprintf('%s-Template.%s', Str::studly($modelKey), $format);

        // Use Laravel's built-in Storage::download for better reliability
        return Storage::disk('public')->download($tempPath, $downloadName);
    }
}
