<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ExportSchedule;
use Illuminate\Support\Facades\Auth;

class ExportScheduleController extends Controller
{
    /**
     * Display list of schedules
     */
    public function index(Request $request)
    {
        $query = ExportSchedule::with('user')->orderBy('created_at', 'desc');

        if ($request->model) {
            $query->where('model_type', $request->model);
        }

        if ($request->status) {
            if ($request->status == 'active') {
                $query->where('is_active', true);
            } elseif ($request->status == 'inactive') {
                $query->where('is_active', false);
            } else {
                $query->where('status', $request->status);
            }
        }

        $schedules = $query->paginate(20);

        $stats = [
            'total' => ExportSchedule::count(),
            'active' => ExportSchedule::where('is_active', true)->count(),
            'pending' => ExportSchedule::where('status', 'pending')->count(),
            'failed' => ExportSchedule::where('status', 'failed')->count(),
        ];

        $models = ExportSchedule::distinct()->pluck('model_type');

        return view('admin.export.schedules', compact('schedules', 'stats', 'models'));
    }

    /**
     * Show create form
     */
    public function create(Request $request)
    {
        $models = [
            'Service', 'Portfolio', 'Blog', 'User', 'TeamMember', 
            'Partner', 'Testimonial', 'CaseStudy'
        ];
        
        return view('admin.export.schedule-form', compact('models'));
    }

    /**
     * Show edit form
     */
    public function edit($id)
    {
        $schedule = ExportSchedule::findOrFail($id);
        
        $models = [
            'Service', 'Portfolio', 'Blog', 'User', 'TeamMember', 
            'Partner', 'Testimonial', 'CaseStudy'
        ];

        return view('admin.export.schedule-form', compact('schedule', 'models'));
    }

    /**
     * Store new schedule
     */
    public function store(Request $request)
    {
        $request->validate([
            'model_type' => 'required|string',
            'format' => 'required|in:csv,xlsx,json',
            'frequency' => 'required|in:daily,weekly,monthly',
            'email_to' => 'nullable|email',
            'filters' => 'nullable|json',
        ]);

        $filters = null;
        if ($request->filters) {
            $filters = json_decode($request->filters, true);
        }

        $schedule = ExportSchedule::create([
            'model_type' => $request->model_type,
            'format' => $request->format,
            'frequency' => $request->frequency,
            'filters' => $filters,
            'email_to' => $request->email_to,
            'is_active' => $request->has('is_active'),
            'user_id' => Auth::id(),
            'status' => 'pending',
            'next_run_at' => now()->addDay(),
        ]);

        return redirect()->route('admin.export.schedules')
            ->with('success', 'Cədvəl uğurla yaradıldı');
    }

    /**
     * Update schedule
     */
    public function update(Request $request, $id)
    {
        $schedule = ExportSchedule::findOrFail($id);

        $request->validate([
            'model_type' => 'required|string',
            'format' => 'required|in:csv,xlsx,json',
            'frequency' => 'required|in:daily,weekly,monthly',
            'email_to' => 'nullable|email',
            'filters' => 'nullable|json',
        ]);

        $filters = null;
        if ($request->filters) {
            $filters = json_decode($request->filters, true);
        }

        $schedule->update([
            'model_type' => $request->model_type,
            'format' => $request->format,
            'frequency' => $request->frequency,
            'filters' => $filters,
            'email_to' => $request->email_to,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.export.schedules')
            ->with('success', 'Cədvəl uğurla yeniləndi');
    }

    /**
     * Toggle active status
     */
    public function toggle(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:export_schedules,id',
            'is_active' => 'required|boolean',
        ]);

        $schedule = ExportSchedule::findOrFail($request->id);
        $schedule->update(['is_active' => $request->is_active]);

        return response()->json([
            'status' => 200,
            'message' => 'Status yeniləndi'
        ]);
    }

    /**
     * Run schedule now
     */
    public function run($id)
    {
        $schedule = ExportSchedule::findOrFail($id);
        
        // Mark as running
        $schedule->markAsRunning();

        // Dispatch export job to queue
        ExportJob::dispatch($schedule);

        return back()->with('success', 'Export işləməyə başladı');
    }

    /**
     * Delete schedule
     */
    public function destroy($id)
    {
        $schedule = ExportSchedule::findOrFail($id);
        $schedule->delete();

        return back()->with('success', 'Cədvəl silindi');
    }
}