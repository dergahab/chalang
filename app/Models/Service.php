<?php

namespace App\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;



class Service extends Model implements TranslatableContract
{
    use HasFactory, Translatable, SoftDeletes;

    public $translatedAttributes = ['name', 'content', 'description', 'slug', 'cta_text'];

    protected $fillable = ['parent_id', 'icon', 'image', 'cta_link', 'status'];

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    // Keep legacy alias just in case
    public function childs()
    {
        return $this->children();
    }

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function scopeParents($query)
    {
        return $query->where('parent_id', 0)->orWhereNull('parent_id');
    }

    public function serviceContent()
    {
        return $this->hasOne(ServisContent::class);
    }

    public function caseStudies()
    {
        return $this->belongsToMany(CaseStudy::class, 'case_study_service');
    }

    public function testimonials()
    {
        return $this->hasMany(Testimonial::class);
    }

    public function faqs()
    {
        return $this->hasMany(Faq::class)->orderBy('sort_order')->where('is_active', true);
    }

    public function resolveRouteBinding($value, $field = null)
    {
        if ($field === 'slug') {
            return $this->whereTranslation('slug', $value)->firstOrFail();
        }

        return parent::resolveRouteBinding($value, $field);
    }
}
