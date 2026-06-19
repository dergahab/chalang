<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\CallRequest;
use App\Models\Submission;
use App\Notifications\NewSubmissionNotification;
use App\Services\NotificationRouter;

class CallRequestController extends Controller
{
    public function __invoke(CallRequest $request)
    {
        $data = $request->validated();

        $submission = Submission::create([
            'type' => 'call',
            'data' => $data,
            'ip_address' => $request->ip(),
            'status' => 'new',
        ]);

        $notification = new NewSubmissionNotification($submission);
        NotificationRouter::notify('call', $notification);

        if ($request->wantsJson()) {
            return response()->json([
                'status' => 201,
                'message' => __('front.contact.success_message'),
            ], 201);
        }

        return back()->with('success', __('front.contact.success_message'));
    }
}
