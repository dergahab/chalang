<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$settings = \App\Models\Setting::all(['key', 'value']);
foreach ($settings as $s) {
    echo "{$s->key}: {$s->value}\n";
}
