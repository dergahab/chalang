<?php

namespace App\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceContentOption extends Model implements TranslatableContract
{
    use HasFactory, Translatable;
    protected $fillable = ['servis_content_id', 'icon', 'content_az', 'content_en','title_az'];
}
