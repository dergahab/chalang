<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function __invoke(Request $request)
    {
        $data = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:50'],
            'message' => ['required', 'string'],
            'type' => ['nullable', 'string', 'max:50'],
        ]);

        Message::create($data);

        return response()->json([
            'status' => 201,
            'message' => __('front.contact.success_message'),
        ], 201);
    }
}
