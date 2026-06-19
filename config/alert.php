<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Alert Channels
    |--------------------------------------------------------------------------
    */
    'default_channel' => 'log',

    // Email recipients
    'emails' => [
        // 'admin@example.com',
    ],

    // Slack webhook URL
    'slack_webhook' => env('SLACK_WEBHOOK_URL'),

    // Custom webhook URL
    'webhook_url' => env('ALERT_WEBHOOK_URL'),

    /*
    |--------------------------------------------------------------------------
    | Alert Rules
    |--------------------------------------------------------------------------
    */
    'rules' => [
        // High error rate (> 5% in 5 minutes)
        'error_rate' => [
            'enabled' => true,
            'threshold' => 5,
            'period_minutes' => 5,
            'channels' => ['email', 'slack'],
        ],

        // Slow response time (> 3 seconds)
        'slow_response' => [
            'enabled' => true,
            'threshold' => 3000,
            'period_minutes' => 5,
            'channels' => ['log'],
        ],

        // Failed logins (> 10 in 15 minutes)
        'failed_logins' => [
            'enabled' => true,
            'threshold' => 10,
            'period_minutes' => 15,
            'channels' => ['email'],
        ],

        // Low disk space (< 10%)
        'disk_space' => [
            'enabled' => true,
            'threshold' => 10,
            'period_minutes' => 60,
            'channels' => ['email', 'slack'],
        ],

        // High memory usage (> 80%)
        'memory_usage' => [
            'enabled' => true,
            'threshold' => 80,
            'period_minutes' => 10,
            'channels' => ['slack'],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Notification Settings
    |--------------------------------------------------------------------------
    */
    'notify_on_success' => false,
    'batch_notifications' => true,
    'batch_interval_minutes' => 15,
];