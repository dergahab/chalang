<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\ExportSchedule;
use App\Http\Controllers\Admin\ExportController;
use Illuminate\Support\Facades\Log;

class ExportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $schedule;
    public $timeout = 300;

    /**
     * Create a new job instance.
     */
    public function __construct(ExportSchedule $schedule)
    {
        $this->schedule = $schedule;
    }

    /**
     * Execute the job.
     */
    public function handle(ExportController $exportController)
    {
        try {
            $this->schedule->markAsRunning();
            
            $result = $exportController->runScheduledExport($this->schedule);
            
            if ($result['success'] ?? false) {
                Log::info("ExportJob completed: {$result['rows']} rows exported");
            } else {
                Log::error("ExportJob failed: " . ($result['error'] ?? 'Unknown error'));
            }
        } catch (\Exception $e) {
            $this->schedule->markAsFailed($e->getMessage());
            Log::error("ExportJob exception: " . $e->getMessage());
            throw $e;
        }
    }
}