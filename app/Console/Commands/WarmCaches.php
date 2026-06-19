<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class WarmCaches extends Command
{
    protected $signature = 'app:warm-caches';

    protected $description = 'Config/route/view cache-ləri isti saxlayır (deploy sonrası manual icra üçün)';

    public function handle(): int
    {
        $this->info('Running config:cache');
        Artisan::call('config:cache');
        $this->line(Artisan::output());

        $this->info('Running route:cache');
        Artisan::call('route:cache');
        $this->line(Artisan::output());

        $this->info('Running view:cache');
        Artisan::call('view:cache');
        $this->line(Artisan::output());

        $this->info('Cache warming completed.');
        return Command::SUCCESS;
    }
}
