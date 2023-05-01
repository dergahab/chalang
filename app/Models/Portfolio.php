<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
class Portfolio extends Model implements TranslatableContract
{
    use HasFactory,Translatable;

    public $translatedAttributes = ['title', 'description', 'slug'];
    protected $fillable = ['image'];
    protected $appends = ['category_ids'];
 
    public function pcategories(){
        return $this->belongsToMany(Pcategory::class, 'pcategory_portfolio');
    }

    public function attachCategories(array $categories){
        $this->pcategories()->attach($categories);
    }
    public function syncCategories(array $categories){
        $this->pcategories()->sync($categories);
    }
    public function getCategoryIdsAttribute()
    {
        return array_column($this->pcategories->toArray(), 'id');
    }
}
