<?php

namespace App\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Partner extends Model implements TranslatableContract
{
    use HasFactory, Translatable, LogsActivity;

    public $translatedAttributes = ['description'];

    protected $fillable = ['name', 'logo', 'link', 'is_active', 'sort_order'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['name', 'logo', 'link', 'is_active', 'sort_order', 'description'])
        ->logOnlyDirty()
        ->dontSubmitEmptyLogs();
    }
}
