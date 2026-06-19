<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ExportHistory;

class ExportHistoryController extends Controller
{
    /**
     * Display export history
     */
    public function index(Request $request)
    {
        $query = ExportHistory::with('user')->orderBy('created_at', 'desc');

        if ($request->model) {
            $query->where('model_type', $request->model);
        }

        if ($request->format) {
            $query->where('format', $request->format);
        }

        if ($request->user_id) {
            $query->where('user_id', $request->user_id);
        }

        $histories = $query->paginate(20);

        $stats = [
            'total' => ExportHistory::count(),
            'total_rows' => ExportHistory::sum('total_rows'),
        ];

        $models = ExportHistory::distinct()->pluck('model_type');
        $formats = ['csv', 'json', 'xlsx', 'html'];

        return view('admin.export.history', compact('histories', 'stats', 'models', 'formats'));
    }

    /**
     * Delete history
     */
    public function destroy($id)
    {
        $history = ExportHistory::findOrFail($id);
        
        // Delete physical file if exists
        if ($history->file_path && \Storage::disk('public')->exists($history->file_path)) {
            \Storage::disk('public')->delete($history->file_path);
        }

        $history->delete();

        return back()->with('success', 'Eksport tarixi və faylı silindi.');
    }

    public function download($id)
    {
        $history = ExportHistory::findOrFail($id);

        if (!$history->file_path || !\Storage::disk('public')->exists($history->file_path)) {
            return back()->with('error', 'Fayl tapılmadı və ya artıq silinib.');
        }

        return \Storage::disk('public')->download($history->file_path, $history->file_name);
    }

    /**
     * Get stats API
     */
    public function stats()
    {
        return response()->json([
            'total' => ExportHistory::count(),
            'total_rows' => ExportHistory::sum('total_rows'),
            'by_model' => ExportHistory::selectRaw('model_type, COUNT(*) as count, SUM(total_rows) as total_rows')
                ->groupBy('model_type')->get(),
            'by_format' => ExportHistory::selectRaw('format, COUNT(*) as count')
                ->groupBy('format')->get(),
        ]);
    }
}