<?php

namespace App\Models;

// use Astrotomic\Translatable\Translatable;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pcategory extends Model implements TranslatableContract
{
    use HasFactory ,Translatable;

    public $translatedAttributes = ['name', 'slug'];

    public function portfolios()
    {
        return $this->belongsToMany(Portfolio::class, 'pcategory_portfolio');
    }
}
