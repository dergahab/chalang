<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cache;

Route::get('/test-cache', function () {
    try {
        Cache::put('test', 'value', 60);
        return 'Cache test successful.';
    } catch (\Exception $e) {
        return 'Cache test failed: ' . $e->getMessage();
    }
});
