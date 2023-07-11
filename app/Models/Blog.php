<?php

namespace App\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model implements TranslatableContract
{
    use HasFactory ,Translatable;

    public $translatedAttributes = ['title',  'content'];

    protected $fillable = ['image', 'big_image', 'slug', 'user_id'];

    public function getCreatedAtAttribute($item)
    {
        return \Carbon\Carbon::parse($item)->diffForHumans();
    }
}
