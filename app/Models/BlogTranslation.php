<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogTranslation extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'content', 'slug', 'locale' ,'blog_id'];

}
