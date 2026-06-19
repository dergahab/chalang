<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Application Feature Flags
    |--------------------------------------------------------------------------
    |
    | This file is used to define the status of various features across the app.
    | You can override these values in your .env file using FEATURE_XXX prefix.
    |
    */

    'ui_v2' => env('FEATURE_UI_V2', false),
    'slack_notifications' => env('FEATURE_SLACK', false),
    'ai_tools' => env('FEATURE_AI_TOOLS', false),

    // Elite Admin Features
    'media_library' => env('FEATURE_MEDIA_LIBRARY', false),
    'crm_orders' => env('FEATURE_CRM_ORDERS', false),
    'crm_demo_packages' => env('FEATURE_CRM_DEMO_PACKAGES', false),
    'marketing_seo_hub' => env('FEATURE_MARKETING_SEO_HUB', false),
    'ops_health_pulse' => env('FEATURE_OPS_HEALTH_PULSE', false),
    'ops_feature_flags_hub' => env('FEATURE_OPS_FEATURE_FLAGS_HUB', false),
    'ops_incidents' => env('FEATURE_OPS_INCIDENTS', false),
    'notification_channels' => env('FEATURE_NOTIFICATION_CHANNELS', false),
    'security_hub_v1' => env('FEATURE_SECURITY_HUB_V1', false),

    // Analytics
    'analytics_tracking' => env('FEATURE_ANALYTICS', false),

];
