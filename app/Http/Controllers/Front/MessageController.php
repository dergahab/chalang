<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Http\Requests\ContactRequest;
use App\Notifications\NewMessageNotification;
use App\Services\NotificationRouter;

class MessageController extends Controller
{
    public function __invoke(ContactRequest $request)
    {
        $data = $request->validated();

        $message = Message::create($data);

        $notification = new NewMessageNotification($message);
        NotificationRouter::notify('contact', $notification);

        return response()->json([
            'status' => 201,
            'message' => __('front.contact.success_message'),
        ], 201);
    }
}
