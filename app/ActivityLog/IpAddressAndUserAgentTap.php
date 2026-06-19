<?php

namespace App\ActivityLog;

use Spatie\Activitylog\Contracts\Activity;

class IpAddressAndUserAgentTap
{
    public function __invoke(Activity $activity, ?string $eventName = null)
    {
        $activity->properties = $activity->properties->merge([
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}
