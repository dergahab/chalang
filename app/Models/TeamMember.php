<?php

namespace App\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class TeamMember extends Model implements TranslatableContract
{
    use HasFactory, Translatable, LogsActivity;

    public $translatedAttributes = ['name', 'position', 'bio', 'specialties'];

    protected $fillable = ['image', 'social_links', 'is_featured', 'sort_order'];

    protected $casts = [
        'social_links' => 'array',
        'is_featured' => 'boolean',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['image', 'social_links', 'is_featured', 'sort_order', 'name', 'position', 'bio', 'specialties'])
        ->logOnlyDirty()
        ->dontSubmitEmptyLogs();
    }
}
