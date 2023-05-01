<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Company extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name','image','slug'];

    public function getImageAttribute($key){
      return  isset($key) ? asset(Storage::url($key)) : null;
    }

}
