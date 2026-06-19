<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $activities = $this->buildQuery($request)->paginate(20);

        $modules = Activity::select('subject_type')
            ->distinct()
            ->whereNotNull('subject_type')
            ->pluck('subject_type')
            ->map(function ($type) {
                $basename = class_basename($type);
                
                // Categorization Logic
                $category = match(true) {
                    in_array($basename, ['Post', 'Portfolio', 'Service', 'Page', 'Category', 'Tag']) => 'Content',
                    in_array($basename, ['Lead', 'Subscriber', 'Contact', 'Message', 'Quote']) => 'CRM',
                    in_array($basename, ['User', 'Role', 'Permission']) => 'Security',
                    in_array($basename, ['Setting', 'Menu', 'Language']) => 'System',
                    default => 'Digər'
                };

                return [
                    'value' => $type,
                    'label' => $basename,
                    'category' => $category
                ];
            })
            ->sortBy('label') // Sort alphabetically within categories
            ->groupBy('category') // Group by category
            ->sortBy(function ($items, $key) {
                // Custom Category Order
                return match($key) {
                    'CRM' => 1,
                    'Content' => 2,
                    'Security' => 3,
                    'System' => 4,
                    default => 5
                };
            });

        $users = \App\Models\User::select('id', 'name')->get();

        // Analytics Data
        $totalActivitiesToday = Activity::whereDate('created_at', today())->count();
        
        $activeUser = Activity::select('causer_id')
            ->where('created_at', '>=', now()->subDays(7))
            ->whereNotNull('causer_id')
            ->groupBy('causer_id')
            ->orderByRaw('COUNT(*) DESC')
            ->with('causer')
            ->first();

        $topModule = Activity::select('subject_type')
            ->where('created_at', '>=', now()->subDays(7))
            ->whereNotNull('subject_type')
            ->groupBy('subject_type')
            ->orderByRaw('COUNT(*) DESC')
            ->first();

        $criticalEvents = Activity::where('description', 'deleted')
            ->where('created_at', '>=', now()->subDays(7))
            ->count();

        return view('admin.pages.activity_log.index', compact(
            'activities', 
            'modules', 
            'users',
            'totalActivitiesToday',
            'activeUser',
            'topModule',
            'criticalEvents'
        ));
    }

    public function export(Request $request)
    {
        $request->validate([
            'format' => 'nullable|in:csv,json,html',
        ]);

        $activities = $this->buildQuery($request)->get();
        $filename = 'activity_log_' . now()->format('Y-m-d_H-i-s');
        $format = $request->input('format', 'csv');

        if ($format === 'json') {
            return response(
                $activities->toJson(JSON_PRETTY_PRINT),
                200,
                [
                    'Content-Type' => 'application/json',
                    'Content-Disposition' => 'attachment; filename="' . $filename . '.json"',
                ]
            );
        }

        if ($format === 'html') {
            $content = '<html><head><meta charset="UTF-8"><style>table{width:100%;border-collapse:collapse;font-family:sans-serif;}th,td{border:1px solid #ddd;padding:8px;text-align:left;}th{background-color:#f2f2f2;}</style></head><body>';
            $content .= '<h2>Activity Log Export</h2>';

            if ($activities->isEmpty()) {
                $content .= '<p>No activity records found.</p>';
            } else {
                $content .= '<table><thead><tr><th>ID</th><th>User</th><th>Event</th><th>Subject</th><th>Subject ID</th><th>Date</th></tr></thead><tbody>';
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
                $content .= '</tbody></table>';
            }

            $content .= '</body></html>';

            return response(
                $content,
                200,
                [
                    'Content-Type' => 'text/html',
                    'Content-Disposition' => 'attachment; filename="' . $filename . '.html"',
                ]
            );
        }

        $handle = fopen('php://temp', 'r+');
        fputs($handle, "\xEF\xBB\xBF");
        fputcsv($handle, ['ID', 'User', 'Event', 'Subject Type', 'Subject ID', 'Description', 'Date']);

        foreach ($activities as $activity) {
            fputcsv($handle, [
                $activity->id,
                $activity->causer ? $activity->causer->name : 'Sistem',
                $activity->description,
                class_basename($activity->subject_type),
                $activity->subject_id,
                $activity->description,
                $activity->created_at->format('Y-m-d H:i:s'),
            ]);
        }

        rewind($handle);
        $csv = stream_get_contents($handle);
        fclose($handle);

        return response(
            $csv,
            200,
            [
                'Content-Type' => 'text/csv; charset=UTF-8',
                'Content-Disposition' => 'attachment; filename="' . $filename . '.csv"',
                'Pragma' => 'no-cache',
                'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
                'Expires' => '0',
            ]
        );
    }

    public function revert($id)
    {
        $activity = Activity::findOrFail($id);

        if ($activity->event === 'updated') {
            $oldProperties = $activity->properties['old'] ?? [];
            if ($activity->subject && !empty($oldProperties)) {
                $activity->subject->update($oldProperties);
                return response()->json(['success' => true, 'message' => 'Dəyişikliklər geri qaytarıldı.']);
            }
        } elseif ($activity->event === 'deleted') {
            if ($activity->subject_type && $activity->subject_id) {
                $modelClass = $activity->subject_type;
                if (class_exists($modelClass)) {
                    if (in_array('Illuminate\Database\Eloquent\SoftDeletes', class_uses($modelClass))) {
                        $record = $modelClass::withTrashed()->find($activity->subject_id);
                        if ($record && $record->trashed()) {
                            $record->restore();
                            return response()->json(['success' => true, 'message' => 'Silinmiş məlumat bərpa edildi.']);
                        }
                    }
                }
            }
        }

        return response()->json(['success' => false, 'message' => 'Bu əməliyyatı geri qaytarmaq mümkün deyil.']);
    }

    public function getHistory(Request $request)
    {
        $request->validate([
            'subject_type' => 'required|string',
            'subject_id' => 'required|integer',
        ]);

        $history = Activity::with('causer')
            ->where('subject_type', $request->subject_type)
            ->where('subject_id', $request->subject_id)
            ->latest()
            ->get();

        return response()->json([
            'html' => view('admin.pages.activity_log.history_list', compact('history'))->render()
        ]);
    }

    public function updateNote(Request $request, $id)
    {
        $request->validate([
            'note' => 'nullable|string|max:1000',
        ]);

        $activity = Activity::findOrFail($id);
        $properties = $activity->properties;
        $properties['admin_note'] = $request->note;
        $activity->properties = $properties;
        $activity->save();

        return response()->json(['success' => true, 'message' => 'Qeyd yadda saxlanıldı.']);
    }

    public function getIpInfo($ip)
    {
        try {
            $response = \Illuminate\Support\Facades\Http::get("http://ip-api.com/json/{$ip}");
            return $response->json();
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        $activity = Activity::with('causer', 'subject')->findOrFail($id);
        
        // Field mapping for readable names
        $fieldMap = [
            'title' => 'Başlıq',
            'name' => 'Ad',
            'slug' => 'Slug (URL)',
            'description' => 'Təsvir',
            'content' => 'Məzmun',
            'image' => 'Şəkil',
            'is_active' => 'Status',
            'order' => 'Sıra',
            'email' => 'Email',
            'phone' => 'Telefon',
            'role' => 'Rol',
            'password' => 'Şifrə',
            'permissions' => 'İcazələr',
            'guard_name' => 'Guard',
            'created_at' => 'Yaradılma Tarixi',
            'updated_at' => 'Yenilənmə Tarixi',
            'deleted_at' => 'Silinmə Tarixi',
            'icon' => 'İkon',
            'link' => 'Link',
            'type' => 'Növ',
            'status' => 'Status',
            'view_count' => 'Baxış Sayı',
            'meta_title' => 'Meta Başlıq',
            'meta_description' => 'Meta Təsvir',
            'meta_keywords' => 'Meta Açar Sözlər',
        ];

        return view('admin.pages.activity_log.modal_content', compact('activity', 'fieldMap'));
    }

    private function buildQuery(Request $request)
    {
        $query = Activity::with('causer', 'subject');

        if ($request->filled('module')) {
            $query->where('subject_type', $request->input('module'));
        }

        if ($request->filled('event')) {
            $query->where('description', $request->input('event'));
        }

        if ($request->filled('user')) {
            $query->where('causer_id', $request->input('user'));
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->input('date_from'));
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->input('date_to'));
        }
        
        if ($request->filled('subject_type') && $request->filled('subject_id')) {
            $query->where('subject_type', $request->input('subject_type'))
                  ->where('subject_id', $request->input('subject_id'));
        }

        // Deep Search (Subject, Causer, Properties)
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                  ->orWhere('properties', 'like', "%{$search}%")
                  ->orWhereHas('causer', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                  });
                
                // Only search subject_id if the input is numeric to avoid SQL errors
                if (is_numeric($search)) {
                    $q->orWhere('subject_id', $search);
                }
            });
        }

        switch ($request->input('sort_by', 'newest')) {
            case 'oldest':
                $query->oldest();
                break;
            case 'user':
                $query->join('users', 'activity_log.causer_id', '=', 'users.id')
                    ->orderBy('users.name', 'asc')
                    ->select('activity_log.*');
                break;
            case 'module':
                $query->orderBy('subject_type', 'asc');
                break;
            default:
                $query->latest();
                break;
        }

        return $query;
    }
}
