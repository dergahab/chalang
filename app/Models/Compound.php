<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Compound extends Model  implements TranslatableContract{

    use HasFactory ,Translatable;

    public $translatedAttributes = ['title', 'contnet'];
    public $fillable = ['related', 'type', 'image'];

    public function subcompunds():HasMany{
        return $this->hasMany(Subcompound::class);
    }
}
