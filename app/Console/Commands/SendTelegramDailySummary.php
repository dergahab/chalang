<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\TelegramService;
use App\Models\User;
use App\Models\Message;
use App\Models\Subscribe;
use Carbon\Carbon;

class SendTelegramDailySummary extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'telegram:daily-summary';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends a daily summary of site statistics to Telegram admins';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(TelegramService $telegram)
    {
        $today = Carbon::today();

        $stats = [
            'users' => User::whereDate('created_at', $today)->count(),
            'leads' => Message::whereDate('created_at', $today)->count(),
            'subscribers' => Subscribe::whereDate('created_at', $today)->count(),
            'visitors' => \App\Models\ActivityLog::whereDate('created_at', $today)->count(), // Yalnız təxmini bir ədəd, ActivityLog varsa
        ];

        $telegram->notifyDailyStats($stats);

        $this->info('Daily summary sent successfully to Telegram.');

        return Command::SUCCESS;
    }
}
