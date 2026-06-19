<?php

namespace App\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PricingPlan extends Model implements TranslatableContract
{
    use HasFactory, Translatable;

    public $translatedAttributes = ['name', 'features', 'cta_text'];

    protected $fillable = ['price_monthly', 'price_yearly', 'cta_link', 'is_popular', 'is_active', 'sort_order'];

    protected $casts = [
        'is_popular' => 'boolean',
        'is_active' => 'boolean',
    ];
}
