<?php

namespace App\Helpers;

use App\Models\Task;

if (!function_exists('task_count_by_status')) {
    function task_count_by_status($status = 0)
    {
        $query = Task::query();

        if ($status) {
            $query->where('status_id', $status);
        }

        if (auth()->check() && auth()->user()->type == 'worker') {
            $query->where(function ($query) {
                $query->whereHas('users', function ($query) {
                    $query->where('user_assign_tasks.user_id', '=', auth()->id());
                })
                    ->orWhere('user_id', '=', auth()->id());
            });
        }

        return $query->count();
    }
}

if (!function_exists('compute_recursive_diff')) {
    /**
     * Compare two arrays recursively and return the difference structure.
     */
    function compute_recursive_diff($old, $new)
    {
        $diff = [];
        $keys = array_unique(array_merge(array_keys((array)$old), array_keys((array)$new)));
        sort($keys);

        foreach ($keys as $key) {
            $o = isset($old[$key]) ? $old[$key] : null;
            $n = isset($new[$key]) ? $new[$key] : null;

            if (is_array($o) && is_array($n)) {
                $recursive = compute_recursive_diff($o, $n);
                if (!empty($recursive)) {
                    $diff[$key] = ['status' => 'recursive', 'children' => $recursive];
                }
            } elseif ($o !== $n) {
                if ($o === null) {
                    $diff[$key] = ['status' => 'added', 'new' => $n];
                } elseif ($n === null) {
                    $diff[$key] = ['status' => 'removed', 'old' => $o];
                } else {
                    $diff[$key] = ['status' => 'modified', 'old' => $o, 'new' => $n];
                }
            } 
            // We ignore unchanged values to keep the diff clean
        }
        return $diff;
    }
}