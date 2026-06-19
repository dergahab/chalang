<?php

return [
    'dsn' => env('SENTRY_LARAVEL_DSN'),

    'release' => env('APP_VERSION') ?: trim(exec('git rev-parse --short HEAD')),
    'environment' => env('SENTRY_ENV', env('APP_ENV', 'production')),

    // Tracing/sampling
    'traces_sample_rate' => (float) env('SENTRY_TRACES_SAMPLE_RATE', 0.1),
    'profiles_sample_rate' => (float) env('SENTRY_PROFILES_SAMPLE_RATE', 0.0),

    // PII masking: IP anonymization, request bodies redacted
    'send_default_pii' => false,
    'before_send' => static function (\Sentry\Event $event): \Sentry\Event {
        return $event;
    },
];
