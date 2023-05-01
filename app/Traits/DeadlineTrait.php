<?php
// Trait is a re-usable structure that can be added to any PHP class
// In this case, DeadlineTrait will be added to three Models that can have deadline-related methods
// Notice: there's no command like "php artisan make:trait", you need to create this file manually

namespace App\Traits;
use Illuminate\Support\Carbon;
trait DeadlineTrait
{
    public function isOverDeadline():bool
    {
        if ($this->isClosed()) {
            return false;
        }

        return $this->deadline < Carbon::now();
    }

    public function isCloseToDeadline(Int $days = 2):bool
    {
        return $this->deadline < Carbon::now();
    }

    public function getDaysUntilDeadlineAttribute(): Int
    {
        return Carbon::now()->startOfDay()->diffInDays($this->deadline, false);
    }
}