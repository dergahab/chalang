<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Message;
use App\Models\Portfolio;
use App\Models\Service;
use App\Models\User;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AnalyticsController extends Controller
{
    public function index()
    {
        // Counts
        $counts = [
            'services' => Service::count(),
            'portfolios' => Portfolio::count(),
            'blogs' => Blog::count(),
            'messages' => Message::count(),
            'users' => User::count(),
            'submissions' => Submission::count(),
        ];

        // Chart Data: Content Distribution
        $contentDistribution = [
            'labels' => ['Xidmətlər', 'Portfolio', 'Bloqlar'],
            'data' => [$counts['services'], $counts['portfolios'], $counts['blogs']]
        ];

        // Chart Data: Messages per day (Last 7 days)
        $messagesPerDay = Message::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->get();
        
        $messageChart = [
            'labels' => $messagesPerDay->pluck('date')->map(function($date) { return Carbon::parse($date)->format('d M'); })->toArray(),
            'data' => $messagesPerDay->pluck('count')->toArray()
        ];

        // Chart Data: Activity Log (Last 7 days) - Assuming activity_log table exists
        // If not using Spatie Activitylog directly in charts yet, we can mock or use a simple query if table exists
        // For now, let's stick to concrete models.

        return view('admin.pages.analytics.index', compact('counts', 'contentDistribution', 'messageChart'));
    }
    public function edit()
    {
        $settings = \App\Models\Setting::pluck('value', 'key')->toArray();
        return view('admin.pages.analytics.edit', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'ga4_measurement_id' => 'nullable|string',
            'meta_pixel_id' => 'nullable|string',
            'yandex_metrica_id' => 'nullable|string',
        ]);

        foreach ($data as $key => $value) {
            \App\Models\Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        return redirect()->back()->with('success', 'Analitika kodları yeniləndi.');
    }
}
