<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Setting extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = ['key', 'value'];

    /**
     * Lightweight cache to avoid repeated queries during a request.
     */
    protected static array $settingsCache = [];

    /**
     * Get a setting value by key.
     */
    public static function getValue(string $key, $default = null)
    {
        if (empty(self::$settingsCache)) {
            self::$settingsCache = self::pluck('value', 'key')->toArray();
        }

        return array_key_exists($key, self::$settingsCache)
            ? self::$settingsCache[$key]
            : $default;
    }

    /**
     * Persist a setting value and update the cache.
     */
    public static function setValue(string $key, $value)
    {
        $setting = self::updateOrCreate(['key' => $key], ['value' => $value]);
        self::$settingsCache[$key] = $value;

        return $setting;
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['key', 'value'])
        ->logOnlyDirty()
        ->dontSubmitEmptyLogs();
    }
}
