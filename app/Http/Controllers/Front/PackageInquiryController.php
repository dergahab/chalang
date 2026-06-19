<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\PackageInquiryRequest;
use App\Models\Submission;
use App\Notifications\NewSubmissionNotification;
use App\Services\NotificationRouter;

class PackageInquiryController extends Controller
{
    public function __invoke(PackageInquiryRequest $request)
    {
        $data = $request->validated();

        $submission = Submission::create([
            'type' => 'package',
            'data' => $data,
            'ip_address' => $request->ip(),
            'status' => 'new',
        ]);

        $notification = new NewSubmissionNotification($submission);
        NotificationRouter::notify('package', $notification);

        if ($request->wantsJson()) {
            return response()->json([
                'status' => 201,
                'message' => __('front.contact.success_message'),
            ], 201);
        }

        return back()->with('success', __('front.contact.success_message'));
    }
}
