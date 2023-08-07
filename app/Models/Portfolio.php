<?php

namespace App\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Portfolio extends Model implements TranslatableContract
{
    use HasFactory,Translatable, SoftDeletes;

    public $translatedAttributes = ['title', 'description'];

    protected $fillable = ['image', 'slug', 'in_main', 'company_id'];

    protected $appends = ['category_ids'];

    public function pcategories()
    {
        return $this->belongsToMany(Pcategory::class, 'pcategory_portfolio');
    }

    public function attachCategories(array $categories)
    {
        $this->pcategories()->attach($categories);
    }

    public function syncCategories(array $categories)
    {
        $this->pcategories()->sync($categories);
    }

    public function getCategoryIdsAttribute()
    {
        return array_column($this->pcategories->toArray(), 'id');
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'parentable')->orderBy('position', 'asc');
    }
}
