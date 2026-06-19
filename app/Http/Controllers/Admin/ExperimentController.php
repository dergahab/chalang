<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Experiment;
use App\Models\ExperimentVariant;
use App\Models\ExperimentResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ExperimentController extends Controller
{
    /**
     * Display a listing of experiments.
     */
    public function index()
    {
        $experiments = Experiment::with(['variants', 'creator'])
            ->withCount(['results'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.pages.experiments.index', compact('experiments'));
    }

    /**
     * Show the form for creating a new experiment.
     */
    public function create()
    {
        return view('admin.pages.experiments.create');
    }

    /**
     * Store a newly created experiment.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'key' => 'required|string|max:100|unique:experiments,key',
            'description' => 'nullable|string',
            'type' => 'required|in:page,component,feature,content',
            'target_audience' => 'nullable|array',
            'traffic_percentage' => 'required|numeric|min:0|max:100',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after:start_date',
            'goals' => 'nullable|array',
            'variants' => 'required|array|min:2|max:10',
            'variants.*.name' => 'required|string|max:100',
            'variants.*.key' => 'required|string|max:50',
            'variants.*.description' => 'nullable|string',
            'variants.*.configuration' => 'nullable|array',
            'variants.*.traffic_weight' => 'required|numeric|min:0|max:100',
            'variants.*.is_control' => 'boolean',
        ]);

        DB::transaction(function () use ($validated) {
            $experiment = Experiment::create([
                'name' => $validated['name'],
                'key' => $validated['key'],
                'description' => $validated['description'],
                'type' => $validated['type'],
                'target_audience' => $validated['target_audience'],
                'traffic_percentage' => $validated['traffic_percentage'],
                'start_date' => $validated['start_date'],
                'end_date' => $validated['end_date'],
                'goals' => $validated['goals'],
                'status' => 'draft',
                'created_by' => auth()->id(),
            ]);

            // Create variants
            $controlCount = 0;
            foreach ($validated['variants'] as $variantData) {
                if ($variantData['is_control']) {
                    $controlCount++;
                }

                ExperimentVariant::create([
                    'experiment_id' => $experiment->id,
                    'name' => $variantData['name'],
                    'key' => $variantData['key'],
                    'description' => $variantData['description'],
                    'configuration' => $variantData['configuration'] ?? [],
                    'traffic_weight' => $variantData['traffic_weight'],
                    'is_control' => $variantData['is_control'] ?? false,
                ]);
            }

            // Ensure exactly one control variant
            if ($controlCount !== 1) {
                throw new \Exception('Experiment must have exactly one control variant');
            }
        });

        return redirect()->route('admin.experiments.index')
            ->with('success', 'Experiment created successfully');
    }

    /**
     * Display the specified experiment.
     */
    public function show(Experiment $experiment)
    {
        $experiment->load(['variants.results', 'creator']);
        $results = $experiment->getResultsSummary();

        // Calculate statistics
        $stats = [
            'total_participants' => $experiment->results()->distinct('session_id')->count(),
            'total_events' => $experiment->results()->count(),
            'duration_days' => $experiment->start_date ? $experiment->start_date->diffInDays(now()) : 0,
        ];

        return view('admin.pages.experiments.show', compact('experiment', 'results', 'stats'));
    }

    /**
     * Show the form for editing the experiment.
     */
    public function edit(Experiment $experiment)
    {
        $experiment->load('variants');
        return view('admin.pages.experiments.edit', compact('experiment'));
    }

    /**
     * Update the specified experiment.
     */
    public function update(Request $request, Experiment $experiment)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'key' => ['required', 'string', 'max:100', Rule::unique('experiments')->ignore($experiment->id)],
            'description' => 'nullable|string',
            'type' => 'required|in:page,component,feature,content',
            'target_audience' => 'nullable|array',
            'traffic_percentage' => 'required|numeric|min:0|max:100',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after:start_date',
            'goals' => 'nullable|array',
            'status' => 'required|in:draft,active,paused,completed',
            'variants' => 'required|array|min:2|max:10',
            'variants.*.id' => 'nullable|exists:experiment_variants,id',
            'variants.*.name' => 'required|string|max:100',
            'variants.*.key' => 'required|string|max:50',
            'variants.*.description' => 'nullable|string',
            'variants.*.configuration' => 'nullable|array',
            'variants.*.traffic_weight' => 'required|numeric|min:0|max:100',
            'variants.*.is_control' => 'boolean',
        ]);

        DB::transaction(function () use ($experiment, $validated) {
            $experiment->update([
                'name' => $validated['name'],
                'key' => $validated['key'],
                'description' => $validated['description'],
                'type' => $validated['type'],
                'target_audience' => $validated['target_audience'],
                'traffic_percentage' => $validated['traffic_percentage'],
                'start_date' => $validated['start_date'],
                'end_date' => $validated['end_date'],
                'goals' => $validated['goals'],
                'status' => $validated['status'],
            ]);

            // Update variants
            $existingVariantIds = [];
            $controlCount = 0;

            foreach ($validated['variants'] as $variantData) {
                if (isset($variantData['is_control']) && $variantData['is_control']) {
                    $controlCount++;
                }

                if (isset($variantData['id'])) {
                    // Update existing variant
                    $variant = ExperimentVariant::find($variantData['id']);
                    $variant->update([
                        'name' => $variantData['name'],
                        'key' => $variantData['key'],
                        'description' => $variantData['description'],
                        'configuration' => $variantData['configuration'] ?? [],
                        'traffic_weight' => $variantData['traffic_weight'],
                        'is_control' => $variantData['is_control'] ?? false,
                    ]);
                    $existingVariantIds[] = $variant->id;
                } else {
                    // Create new variant
                    $variant = ExperimentVariant::create([
                        'experiment_id' => $experiment->id,
                        'name' => $variantData['name'],
                        'key' => $variantData['key'],
                        'description' => $variantData['description'],
                        'configuration' => $variantData['configuration'] ?? [],
                        'traffic_weight' => $variantData['traffic_weight'],
                        'is_control' => $variantData['is_control'] ?? false,
                    ]);
                    $existingVariantIds[] = $variant->id;
                }
            }

            // Ensure exactly one control variant
            if ($controlCount !== 1) {
                throw new \Exception('Experiment must have exactly one control variant');
            }

            // Delete removed variants
            $experiment->variants()->whereNotIn('id', $existingVariantIds)->delete();
        });

        return redirect()->route('admin.experiments.show', $experiment)
            ->with('success', 'Experiment updated successfully');
    }

    /**
     * Remove the specified experiment.
     */
    public function destroy(Experiment $experiment)
    {
        $experiment->delete();

        return redirect()->route('admin.experiments.index')
            ->with('success', 'Experiment deleted successfully');
    }

    /**
     * Start the experiment.
     */
    public function start(Experiment $experiment)
    {
        if ($experiment->status !== 'draft') {
            return redirect()->back()->with('error', 'Only draft experiments can be started');
        }

        $experiment->update([
            'status' => 'active',
            'start_date' => now(),
        ]);

        return redirect()->back()->with('success', 'Experiment started successfully');
    }

    /**
     * Pause the experiment.
     */
    public function pause(Experiment $experiment)
    {
        if ($experiment->status !== 'active') {
            return redirect()->back()->with('error', 'Only active experiments can be paused');
        }

        $experiment->update(['status' => 'paused']);

        return redirect()->back()->with('success', 'Experiment paused successfully');
    }

    /**
     * Resume the experiment.
     */
    public function resume(Experiment $experiment)
    {
        if ($experiment->status !== 'paused') {
            return redirect()->back()->with('error', 'Only paused experiments can be resumed');
        }

        $experiment->update(['status' => 'active']);

        return redirect()->back()->with('success', 'Experiment resumed successfully');
    }

    /**
     * Complete the experiment.
     */
    public function complete(Experiment $experiment)
    {
        if (!in_array($experiment->status, ['active', 'paused'])) {
            return redirect()->back()->with('error', 'Only active or paused experiments can be completed');
        }

        $experiment->update([
            'status' => 'completed',
            'end_date' => now(),
        ]);

        return redirect()->back()->with('success', 'Experiment completed successfully');
    }

    /**
     * Get experiment results as JSON.
     */
    public function results(Experiment $experiment)
    {
        $results = $experiment->getResultsSummary();

        return response()->json([
            'experiment' => $experiment,
            'results' => $results,
            'stats' => [
                'total_participants' => $experiment->results()->distinct('session_id')->count(),
                'total_events' => $experiment->results()->count(),
                'duration_days' => $experiment->start_date ? $experiment->start_date->diffInDays(now()) : 0,
            ],
        ]);
    }

    /**
     * Get statistical significance analysis.
     */
    public function statistics(Experiment $experiment)
    {
        $statsService = app(\App\Services\StatisticalSignificanceService::class);

        $analysis = $statsService->calculate($experiment->id);

        return response()->json($analysis);
    }

    /**
     * Get real-time metrics.
     */
    public function realtimeMetrics(Experiment $experiment)
    {
        $statsService = app(\App\Services\StatisticalSignificanceService::class);

        $metrics = $statsService->getRealtimeMetrics($experiment->id);
        $probabilities = $statsService->calculateProbabilityBest($experiment->id);

        return response()->json([
            'experiment' => [
                'id' => $experiment->id,
                'name' => $experiment->name,
                'status' => $experiment->status,
            ],
            'metrics' => $metrics,
            'probabilities' => $probabilities,
            'timestamp' => now()->toIso8601String(),
        ]);
    }
}
