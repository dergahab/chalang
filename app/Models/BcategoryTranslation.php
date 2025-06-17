<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BcategoryTranslation extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug'];

    public function bcategory():BelongsTo {
        return $this->belongsTo(Bcategory::class,'bcategory_id');
    }
}
