<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    use HasFactory;

    protected $fillable = ['type', 'data', 'status', 'ip_address'];

    protected $casts = [
        'data' => 'array',
    ];
}
