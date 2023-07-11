<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContenttextTranslation extends Model
{
    use HasFactory;

    public $fillable = ['title', 'content', 'locale', 'contenttext_id'];
}
