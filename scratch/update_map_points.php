<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Contenttext;

$key = 'preview.process.map_points';
$newValue = '[{"label":"New York","top":27.4,"left":29.4},{"label":"Switzerland","top":24.0,"left":52.3},{"label":"Bakı","top":27.6,"left":63.9},{"label":"Dubai","top":36.0,"left":65.4}]';

$record = Contenttext::where('key', $key)->first();
if ($record) {
    foreach (['az', 'en', 'ru'] as $locale) {
        $record->translateOrNew($locale)->content = $newValue;
    }
    $record->save();
    echo "Done!\n";
} else {
    echo "Record not found\n";
}
