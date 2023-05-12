<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Illuminate\Database\Eloquent\SoftDeletes;
use Astrotomic\Translatable\Translatable;
class Service extends Model implements TranslatableContract
{
    use HasFactory,Translatable,SoftDeletes;

    public $translatedAttributes = ['name', 'content'];

    protected $fillable = ['parent_id', 'icon', 'slug', 'image'];
    
    public function childs(){
        return $this->hasMany(self::class,'parent_id');
    }

    

}
