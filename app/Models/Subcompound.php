<?php

namespace App\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subcompound extends Model implements TranslatableContract
{
    use HasFactory,Translatable;

    protected $fillable = ['compound_id', 'image'];

    public $translatedAttributes = ['name', 'content'];
}
