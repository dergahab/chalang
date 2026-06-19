<?php

namespace App\Helpers;

class FeatureFlag
{
    /**
     * Check if a feature is enabled.
     *
     * @param string $feature
     * @param bool $default
     * @return bool
     */
    public static function isEnabled(string $feature, bool $default = false): bool
    {
        $envKey = 'FEATURE_' . strtoupper($feature);
        
        // Priority: ENV > Config > Default
        return filter_var(env($envKey, config("features.$feature", $default)), FILTER_VALIDATE_BOOLEAN);
    }

    /**
     * Shortcut for UI V2 (Glassmorphism)
     *
     * @return bool
     */
    public static function isUiV2Enabled(): bool
    {
        return self::isEnabled('ui_v2', false);
    }
}
