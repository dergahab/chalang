<?php

namespace App\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class CaseStudy extends Model implements TranslatableContract
{
    use HasFactory, Translatable, SoftDeletes, LogsActivity;

    public $translatedAttributes = ['title', 'slug', 'problem', 'solution', 'result', 'category'];

    protected $fillable = ['cover_image', 'kpi_data', 'gallery_images', 'in_main', 'sort_order'];

    protected $casts = [
        'kpi_data' => 'array',
        'gallery_images' => 'array',
        'in_main' => 'boolean',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['cover_image', 'kpi_data', 'gallery_images', 'in_main', 'sort_order', 'title', 'slug', 'problem', 'solution', 'result', 'category'])
        ->logOnlyDirty()
        ->dontSubmitEmptyLogs();
    }

    public function services()
    {
        return $this->belongsToMany(Service::class, 'case_study_service');
    }
}
