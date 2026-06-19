<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class BulkActionController extends Controller
{
    public function delete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'model' => 'required|string',
        ]);

        $modelClass = $request->model;

        if (!class_exists($modelClass)) {
            return response()->json(['message' => 'Model not found'], 404);
        }

        // Determine permission name based on model
        // Example: App\Models\Service -> service.delete
        $modelName = strtolower(class_basename($modelClass));
        $permission = $modelName . '.delete';
        
        // Special case for multi-word models if needed, but standardizing on simple names is better
        // For now assuming standard naming convention matches permissions

        if (!auth()->user()->can($permission)) {
             return response()->json(['message' => 'İcazəniz yoxdur!'], 403);
        }

        try {
            $modelClass::whereIn('id', $request->ids)->delete();
            return response()->json(['message' => 'Seçilənlər uğurla silindi!']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Xəta baş verdi: ' . $e->getMessage()], 500);
        }
    }
    public function revert(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'model' => 'required|string',
        ]);

        if ($request->model !== 'Spatie\Activitylog\Models\Activity') {
             return response()->json(['message' => 'Bu əməliyyat yalnız aktivlik loqu üçün keçərlidir!'], 400);
        }

        $count = 0;
        $activities = $request->model::whereIn('id', $request->ids)->get();

        foreach ($activities as $activity) {
            $success = false;
            
            if ($activity->description === 'updated') {
                $oldProperties = $activity->properties['old'] ?? [];
                if ($activity->subject && !empty($oldProperties)) {
                    $activity->subject->update($oldProperties);
                    $success = true;
                }
            } elseif ($activity->description === 'deleted') {
                if ($activity->subject_type && $activity->subject_id) {
                    $modelClass = $activity->subject_type;
                    if (class_exists($modelClass)) {
                        if (in_array('Illuminate\Database\Eloquent\SoftDeletes', class_uses($modelClass))) {
                            $record = $modelClass::withTrashed()->find($activity->subject_id);
                            if ($record && $record->trashed()) {
                                $record->restore();
                                $success = true;
                            }
                        }
                    }
                }
            }

            if ($success) {
                $count++;
            }
        }

        return response()->json(['message' => $count . ' əməliyyat geri qaytarıldı!']);
    }

    public function export(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'model' => 'required|string',
            'format' => 'nullable|in:csv,json,html',
        ]);

        $format = $request->input('format', 'csv');
        $activities = $request->model::whereIn('id', $request->ids)->with('causer', 'subject')->get();
        $filename = "activity_log_" . date('Y-m-d_H-i-s'); 

        if ($format === 'json') {
            $content = $activities->toJson(JSON_PRETTY_PRINT);
            return response($content, 200, [
                'Content-Type' => 'application/json',
                'Content-Disposition' => 'attachment; filename="' . $filename . '.json"',
            ]);
        } elseif ($format === 'html') {
            $content = '<html><head><style>table{width:100%;border-collapse:collapse;font-family:sans-serif;}th,td{border:1px solid #ddd;padding:8px;text-align:left;}th{background-color:#f2f2f2;}</style></head><body>';
            $content .= '<h2>Fəaliyyət Jurnalı Eksportu</h2>';
            $content .= '<table><thead><tr><th>ID</th><th>İstifadəçi</th><th>Hadisə</th><th>Obyekt</th><th>ID</th><th>Tarix</th></tr></thead><tbody>';
            foreach ($activities as $activity) {
                $content .= '<tr>';
                $content .= '<td>' . $activity->id . '</td>';
                $content .= '<td>' . ($activity->causer ? $activity->causer->name : 'Sistem') . '</td>';
                $content .= '<td>' . $activity->description . '</td>';
                $content .= '<td>' . class_basename($activity->subject_type) . '</td>';
                $content .= '<td>' . $activity->subject_id . '</td>';
                $content .= '<td>' . $activity->created_at->format('Y-m-d H:i:s') . '</td>';
                $content .= '</tr>';
            }
            $content .= '</tbody></table></body></html>';
            
            return response($content, 200, [
                'Content-Type' => 'text/html',
                'Content-Disposition' => 'attachment; filename="' . $filename . '.html"',
            ]);
        } else {
            // Default CSV
            $handle = fopen('php://temp', 'r+');
            // Add BOM for Excel UTF-8 compatibility
            fputs($handle, "\xEF\xBB\xBF");
            
            $columns = ['ID', 'User', 'Event', 'Subject Type', 'Subject ID', 'Description', 'Date'];
            fputcsv($handle, $columns);

            foreach ($activities as $activity) {
                $row = [
                    $activity->id,
                    $activity->causer ? $activity->causer->name : 'Sistem',
                    $activity->description,
                    class_basename($activity->subject_type),
                    $activity->subject_id,
                    $activity->description,
                    $activity->created_at->format('Y-m-d H:i:s'),
                ];
                fputcsv($handle, $row);
            }
            
            rewind($handle);
            $content = stream_get_contents($handle);
            fclose($handle);

            return response($content, 200, [
                'Content-Type' => 'text/csv; charset=UTF-8',
                'Content-Disposition' => 'attachment; filename="' . $filename . '.csv"',
                'Pragma' => 'no-cache',
                'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
                'Expires' => '0'
            ]);
        }
    }
}
