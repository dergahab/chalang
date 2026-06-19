<?php

return [
    // The Telegram Bot token
    'token' => env('TELEGRAM_TOKEN'),

    // Nutgram configuration
    'config' => [],

    // Proxy configuration
    'proxy' => env('TELEGRAM_PROXY'),

    // The list of routes to load
    'routes' => base_path('routes/telegram.php'),

    // The bot username
    'bot_username' => 'ChalangAI_bot',

    // Webhook secret for security (mütləq təyin edilməlidir, .env.example-a bax)
    'webhook_secret' => env('TELEGRAM_WEBHOOK_SECRET'),
];
