<?php

use Illuminate\Support\Facades\Session;

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$request = Illuminate\Http\Request::capture();
$app->instance('request', $request);

$kernel->handle($request);

echo "Current session lang: " . Session::get('lang', 'NOT SET') . "\n";
echo "App locale: " . app()->getLocale() . "\n";
