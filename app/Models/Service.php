<?php

namespace App\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model implements TranslatableContract
{
    use HasFactory,Translatable,SoftDeletes;

    public $translatedAttributes = ['name', 'content', 'description', 'slug' ];

    protected $fillable = ['parent_id', 'icon', 'slug', 'image', 'in_main'];

    public function childs()
    {
        return $this->hasMany(self::class, 'parent_id');
    }


    public function content()
    {
        return $this->hasOne(ServisContent::class);
    }
}
