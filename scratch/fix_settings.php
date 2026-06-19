<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

\App\Models\Setting::updateOrCreate(['key' => 'theme_color_secondary_light'], ['value' => '#d500f9']);
\App\Models\Setting::updateOrCreate(['key' => 'theme_font_family'], ['value' => 'Outfit']);

echo "Settings updated successfully.\n";
