<?php

namespace App\Console\Commands;

use App\Models\ExportSchedule;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class RunScheduledExport extends Command
{
    protected $signature = 'export:run-scheduled {--schedule= : Specific schedule ID to run}';
    protected $description = 'Run scheduled exports based on cron';

    public function handle()
    {
        $scheduleId = $this->option('schedule');
        
        $query = ExportSchedule::query();
        
        if ($scheduleId) {
            $query->where('id', $scheduleId);
        } else {
            $query->active()->where('status', '!=', 'running');
        }
        
        $schedules = $query->get();
        
        $this->info("Found {$schedules->count()} schedule(s) to process.");
        
        foreach ($schedules as $schedule) {
            $this->processSchedule($schedule);
        }
        
        return 0;
    }

    private function processSchedule(ExportSchedule $schedule): void
    {
        try {
            $schedule->markAsRunning();
            
            $this->info("Processing schedule #{$schedule->id} for {$schedule->model_type}...");
            
            // Build export using ExportController logic
            $modelClass = 'App\\Models\\' . $schedule->model_type;
            
            if (!class_exists($modelClass)) {
                $schedule->markAsFailed("Model not found: {$schedule->model_type}");
                return;
            }
            
            $query = $modelClass::query();
            
            // Apply filters
            $filters = $schedule->filters ?? [];
            if (!empty($filters)) {
                foreach ($filters as $key => $value) {
                    if ($value) {
                        $query->where($key, $value);
                    }
                }
            }
            
            $data = $query->get();
            
            if ($data->isEmpty()) {
                $schedule->markAsFailed("No data found");
                return;
            }
            
            // Export based on format
            $filename = $schedule->model_type . '_export_' . now()->format('Y-m-d_H-i-s');
            
            switch ($schedule->format) {
                case 'json':
                    $content = json_encode($data->toArray(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                    $filename .= '.json';
                    break;
                case 'xlsx':
                    // Note: Requires maatwebsite/excel package
                    $content = json_encode($data->toArray(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                    $filename .= '.csv'; // Fallback
                    break;
                case 'csv':
                default:
                    $content = $this->toCsv($data);
                    $filename .= '.csv';
                    break;
            }
            
            // Save file
            $path = 'exports/' . $filename;
            Storage::disk('public')->put($path, $content);
            
            // Send email if configured
            if ($schedule->email_to) {
                $this->sendEmail($schedule->email_to, $path, $filename);
            }
            
            $schedule->markAsCompleted($filename);
            
            $this->info("Export completed: {$filename}");
            
        } catch (\Exception $e) {
            Log::error('Scheduled export failed: ' . $e->getMessage());
            $schedule->markAsFailed($e->getMessage());
            $this->error("Failed: " . $e->getMessage());
        }
    }

    private function toCsv($data): string
    {
        if ($data->isEmpty()) {
            return '';
        }
        
        $headers = array_keys($data->first()->toArray());
        
        $handle = fopen('php://temp', 'r+');
        fwrite($handle, "\xEF\xBB\xBF");
        fputcsv($handle, $headers);
        
        foreach ($data as $row) {
            fputcsv($handle, array_values($row->toArray()));
        }
        
        rewind($handle);
        $content = stream_get_contents($handle);
        fclose($handle);
        
        return $content;
    }

    private function sendEmail(string $emails, string $path, string $filename): void
    {
        $emails = explode(',', $emails);
        
        foreach ($emails as $email) {
            $email = trim($email);
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                continue;
            }
            
            try {
                Mail::raw('Scheduled export completed: ' . $filename, function ($message) use ($email, $filename, $path) {
                    $message->to($email)
                        ->subject('Export: ' . $filename)
                        ->attach(storage_path('app/public/' . $path));
                });
            } catch (\Exception $e) {
                Log::warning("Email send failed: " . $e->getMessage());
            }
        }
    }
}