<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class File extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = ['name','path','type','task_id'];


    public function getPathAttribute($key)
    {
        return asset( Storage::url($key));
    }
}
