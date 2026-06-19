<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$about = \App\Models\About::first();
if ($about) {
    $about->image = '/assets/media/about/about-1.png';
    $about->save();
    echo "SUCCESS: Image updated to " . $about->image . "\n";
} else {
    echo "ERROR: About model not found\n";
}
