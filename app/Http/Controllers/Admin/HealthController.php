<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class HealthController extends Controller
{
    public function status()
    {
        // Database Check
        try {
            DB::connection()->getPdo();
            $dbStatus = 'ok';
            $dbLatency = $this->measure(fn() => DB::select('SELECT 1'));
        } catch (\Exception $e) {
            $dbStatus = 'error';
            $dbLatency = 0;
        }

        // Cache Check (File or Redis)
        try {
            $cacheStatus = 'ok';
            Cache::put('health_check', 'ok', 10);
            $cacheLatency = $this->measure(fn() => Cache::get('health_check'));
        } catch (\Exception $e) {
            $cacheStatus = 'error';
            $cacheLatency = 0;
        }

        // Disk Usage
        $diskFree = disk_free_space(base_path());
        $diskTotal = disk_total_space(base_path());
        $diskUsage = round((($diskTotal - $diskFree) / $diskTotal) * 100, 1);

        return response()->json([
            'database' => [
                'status' => $dbStatus,
                'latency' => $dbLatency . 'ms',
            ],
            'cache' => [
                'status' => $cacheStatus,
                'latency' => $cacheLatency . 'ms',
            ],
            'system' => [
                'disk_usage' => $diskUsage . '%',
                'php_version' => PHP_VERSION,
                'server_time' => now()->toDateTimeString(),
            ]
        ]);
    }

    private function measure($callback)
    {
        $start = microtime(true);
        $callback();
        $end = microtime(true);
        return round(($end - $start) * 1000, 2);
    }
}
