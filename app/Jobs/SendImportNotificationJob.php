<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Models\ImportHistory;

class SendImportNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public int $historyId,
        public string $email
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $history = ImportHistory::find($this->historyId);
        
        if (!$history) {
            return;
        }

        try {
            Mail::send([], [], function ($message) {
                $message->to($this->email)
                    ->subject('İmport Tamamlandı - ' . $history->model_type)
                    ->html($this->buildHtml($history));
            });
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::warning('Email send failed: ' . $e->getMessage());
        }
    }

    /**
     * Build HTML email content
     */
    private function buildHtml($history): string
    {
        $statusEmoji = match($history->status) {
            'completed' => '✅',
            'failed' => '❌',
            default => '⏳'
        };

        return "
        <!DOCTYPE html>
        <html>
        <head>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                .card { background: #f9f9f9; border-radius: 8px; padding: 20px; margin: 10px 0; }
                .stat { display: inline-block; margin: 10px 20px 10px 0; }
                .stat-value { font-size: 24px; font-weight: bold; color: #4b0082; }
                .stat-label { font-size: 12px; color: #666; }
                .btn { display: inline-block; padding: 10px 20px; background: #4b0082; color: white; text-decoration: none; border-radius: 5px; }
            </style>
        </head>
        <body>
            <div class='container'>
                <h2>{$statusEmoji} İmport Tamamlandı</h2>
                
                <div class='card'>
                    <p><strong>Model:</strong> {$history->model_type}</p>
                    <p><strong>Fayl:</strong> {$history->file_name}</p>
                    <p><strong>Status:</strong> {$history->status}</p>
                </div>
                
                <div class='card'>
                    <div class='stat'>
                        <div class='stat-value'>{$history->total_rows}</div>
                        <div class='stat-label'>Cəmi</div>
                    </div>
                    <div class='stat'>
                        <div class='stat-value'>{$history->created_rows}</div>
                        <div class='stat-label'>Yaradılan</div>
                    </div>
                    <div class='stat'>
                        <div class='stat-value'>{$history->updated_rows}</div>
                        <div class='stat-label'>Yenilənən</div>
                    </div>
                    <div class='stat'>
                        <div class='stat-value'>{$history->failed_rows}</div>
                        <div class='stat-label'>Xəta</div>
                    </div>
                </div>
                
                <p style='color: #666; font-size: 12px;'>
                    Tarix: {$history->completed_at?->format('d.m.Y H:i')}
                </p>
            </div>
        </body>
        </html>
        ";
    }
}