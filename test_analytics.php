<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

try {
    $analytics = app('App\Services\AnalyticsService');

    // Create a mock request
    $request = app('Illuminate\Http\Request');
    $request->initialize(
        [], // GET
        [], // POST
        [], // attributes
        [], // cookies
        [], // files
        ['REQUEST_METHOD' => 'GET', 'HTTP_USER_AGENT' => 'Mozilla/5.0 Test/1.0'],
        'http://127.0.0.1/test-page'
    );

    // Track a page view
    $analytics->trackPageView($request, 'Test Page');
    echo "Page view tracked\n";

    // Track a click event
    $analytics->trackClick($request, 'test-button');
    echo "Click event tracked\n";

    // Track a conversion
    $analytics->trackConversion($request, 'purchase', 99.99);
    echo "Conversion tracked\n";

    // Test getting summary
    $summary = $analytics->getAnalyticsSummary(30);
    echo "Summary data retrieved!\n";
    echo "Page Views: " . ($summary['page_views'] ?? 0) . "\n";
    echo "Clicks: " . ($summary['clicks'] ?? 0) . "\n";
    echo "Conversions: " . ($summary['conversions'] ?? 0) . "\n";

    echo "\nAnalytics system is working correctly!\n";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}