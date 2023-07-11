<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable ,HasRoles ,SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $appends = ['full_name', 'role'];

    protected $fillable = [
        'name', 'surname',
        'email', 'image',
        'password',
        'department_id', 'position_id', 'user_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'type',
    ];

    public function getRoleAttribute()
    {
        return $this->getRoleNames();
    }

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getRoleTitleAttribute()
    {
        return $this->roles->first()->name;
    }

    public function getFuLLNameAttribute()
    {
        return $this->name.' '.$this->surname;
    }

    public function position(): BelongsTo
    {
        return $this->belongsTo(Position::class, 'position_id');
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function task(): BelongsToMany
    {
        return $this->belongsToMany(Task::class, 'user_assign_tasks', 'task_id', 'user_id');
    }

    public function getImageAttribute($key)
    {
        $image = asset('images/default-profile.jpg');
        // if(isset($key)){
        //    $image = asset( Storage::url($key));
        // }
        return $image;
    }
}
