<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Schema;

class QueueHealthCheck extends Command
{
    protected $signature = 'queue:health 
        {--queue=default : Queue name/connection}
        {--max-size=100 : Max allowed pending jobs before failing}
        {--max-failed=0 : Max allowed failed jobs before failing}';

    protected $description = 'Checks queue size/failed counts and returns non-zero if thresholds are exceeded';

    public function handle(): int
    {
        $queue = $this->option('queue');
        $maxSize = (int) $this->option('max-size');
        $maxFailed = (int) $this->option('max-failed');

        $size = Queue::size($queue);
        $failed = $this->failedCount($queue);

        $this->line("Queue '{$queue}': pending={$size}, failed={$failed}");

        $violations = [];
        if ($size > $maxSize) {
            $violations[] = "pending>{$maxSize}";
        }
        if ($failed > $maxFailed) {
            $violations[] = "failed>{$maxFailed}";
        }

        if (!empty($violations)) {
            $this->error('Queue health check failed: ' . implode(', ', $violations));
            return Command::FAILURE;
        }

        $this->info('Queue health OK');
        return Command::SUCCESS;
    }

    private function failedCount(string $queue): int
    {
        if (!Schema::hasTable('failed_jobs')) {
            return 0;
        }

        return DB::table('failed_jobs')
            ->when($queue, fn($q) => $q->where('queue', $queue))
            ->count();
    }
}
