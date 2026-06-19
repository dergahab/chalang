<?php

namespace App\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Blog extends Model implements TranslatableContract
{
    use HasFactory, Translatable, LogsActivity;

    public $translatedAttributes = ['title', 'content', 'slug'];

    protected $fillable = ['image', 'big_image', 'user_id', 'status'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['image', 'big_image', 'slug', 'user_id', 'title', 'content', 'status'])
        ->logOnlyDirty()
        ->dontSubmitEmptyLogs();
    }

    public function getCreatedAtAttribute($item)
    {
        return \Carbon\Carbon::parse($item)->diffForHumans();
    }

    public function resolveRouteBinding($value, $field = null)
    {
        if ($field === 'slug') {
            return $this->whereTranslation('slug', $value)->firstOrFail();
        }

        return parent::resolveRouteBinding($value, $field);
    }
}
