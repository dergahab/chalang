<?php

namespace App\Helpers;

use App\Models\Task;

class Helpers
{
    public static function task_count_by_status($status = 0)
    {
        $count = new Task();

        if ($status != 0) {
            $count = $count->where('status_id', $status);
        }

        if (auth()->user()->type == 'worker') {
            $count = $count->where(function ($query) {
                $query->whereHas('users', function ($query) {
                    $query->where('user_assign_tasks.user_id', '=', auth()->user()->id);
                })
                    ->orWhere('user_id', '=', auth()->user()->id);
            });
        }

        return $count->count();
    }
}


function portfolio_filter(string $filter)
{
    return preg_replace('"/[^/*\ ]+/"', '-', $filter);
}