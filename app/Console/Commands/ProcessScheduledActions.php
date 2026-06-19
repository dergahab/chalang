<?php

namespace App\Console\Commands;

use App\Services\ScheduledActionService;
use Illuminate\Console\Command;

class ProcessScheduledActions extends Command
{
    protected $signature = 'scheduled-actions:process {--queue : Process queue instead of blocking}';
    protected $description = 'Process scheduled bulk actions';

    public function handle(): int
    {
        $result = ScheduledActionService::processDueActions();

        $this->info("Processed {$result['processed']} actions at {$result['timestamp']}");

        return Command::SUCCESS;
    }
}