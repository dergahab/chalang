<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Blog extends Model implements TranslatableContract
{
    use HasFactory ,Translatable;
    public $translatedAttributes = ['title',  'content'];
    protected $fillable = ['image', 'big_image','slug',"user_id"];

    public function getCreatedAtAttribute($item){
         return \Carbon\Carbon::parse($item)->diffForHumans();
    }
   
}
