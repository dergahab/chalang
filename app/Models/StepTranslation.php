<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StepTranslation extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'step', 'step_id', 'locale'];
}
