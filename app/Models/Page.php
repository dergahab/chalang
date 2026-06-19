<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'title',
        'content',
        'status',
        'meta',
    ];

    protected $casts = [
        'content' => 'array',
        'meta' => 'array',
    ];
}
