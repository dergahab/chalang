<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use SergiX44\Nutgram\Nutgram;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class TelegramHealthController extends Controller
{
    public function check(Nutgram $bot)
    {
        $apiStatus = 'offline';
        $webhookInfo = null;
        $responseTime = 0;
        
        try {
            $start = microtime(true);
            $webhookInfo = $bot->getWebhookInfo();
            $responseTime = round((microtime(true) - $start) * 1000, 1);
            $apiStatus = 'online';
        } catch (\Exception $e) {
            $apiStatus = 'error: ' . $e->getMessage();
        }

        // Təhlükəsiz Queue Yoxlanışı
        $hasJobsTable = Schema::hasTable('jobs');
        $hasFailedJobsTable = Schema::hasTable('failed_jobs');

        $pendingJobs = $hasJobsTable 
            ? DB::table('jobs')->where('payload', 'like', '%ProcessTelegramNotification%')->count() 
            : 0;
            
        $failedJobs = $hasFailedJobsTable 
            ? DB::table('failed_jobs')->where('payload', 'like', '%ProcessTelegramNotification%')->count() 
            : 0;

        return response()->json([
            'success' => true,
            'api_status' => $apiStatus,
            'response_time_ms' => $responseTime,
            'webhook' => [
                'is_set' => !empty($webhookInfo?->url),
                'url' => $webhookInfo?->url ?? null,
                'pending_update_count' => $webhookInfo?->pending_update_count ?? 0,
                'last_error_message' => $webhookInfo?->last_error_message ?? null,
            ],
            'queue' => [
                'is_ready' => $hasJobsTable,
                'connection' => config('queue.default'),
                'pending_jobs' => $pendingJobs,
                'failed_jobs' => $failedJobs,
            ]
        ]);
    }
}
