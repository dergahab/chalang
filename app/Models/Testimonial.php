<?php

namespace App\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Testimonial extends Model implements TranslatableContract
{
    use HasFactory, Translatable, LogsActivity;

    public $translatedAttributes = ['name', 'position', 'content'];

    protected $fillable = ['platform', 'rating', 'image', 'is_active', 'sort_order', 'service_id', 'project_type', 'outcome'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['platform', 'rating', 'image', 'is_active', 'sort_order', 'service_id', 'name', 'position', 'content'])
        ->logOnlyDirty()
        ->dontSubmitEmptyLogs();
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
