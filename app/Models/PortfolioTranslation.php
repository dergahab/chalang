<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PortfolioTranslation extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'slug', 'short_description', 'problem', 'solution', 'result', 'locale', 'portfolio_id'];
}
