<?php

namespace App\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Faq extends Model implements TranslatableContract
{
    use HasFactory, Translatable, LogsActivity;

    public $translatedAttributes = ['question', 'answer'];

    protected $fillable = ['category', 'is_active', 'sort_order', 'service_id'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['category', 'is_active', 'sort_order', 'question', 'answer', 'service_id'])
        ->logOnlyDirty()
        ->dontSubmitEmptyLogs();
    }
    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
