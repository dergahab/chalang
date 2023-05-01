<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Blog extends Model implements TranslatableContract
{
    use HasFactory ,Translatable;
    public $translatedAttributes = ['title', 'slug', 'content'];
    protected $fillable = ['image', "user_id"];
   
}
