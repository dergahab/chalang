<?php

namespace App\Helpers;


class RouteHelpers {
    public static function getToggleRoute($model, $id = null): string {
        if ($id) {
            return route('toggle_publish', ['cmid' => $id, 'classPath' => get_class($model)]);
        }

        return route('toggle_publish', ['cmid' => $model->id, 'classPath' => get_class($model)]);
    }
}
