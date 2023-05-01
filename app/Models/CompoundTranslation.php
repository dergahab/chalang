<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompoundTranslation extends Model
{
    use HasFactory;

    public $fillable = ['title', 'content','locale','compound_id'];
}
