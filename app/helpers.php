<?php

namespace App\Helpers;

use App\Models\Task;

if (!function_exists('task_count_by_status')) {
    function task_count_by_status($status = 0)
    {
        $count = new Task();

        if (!$status) {
            $count = $count->wher('status_id', $status);
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
