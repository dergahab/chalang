<?php

namespace App\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;

class Post extends   Model implements TranslatableContract
{
    use HasFactory ,Translatable;

    public $translatedAttributes = ['title', 'content'];
    protected $fillable = ['author'];

}