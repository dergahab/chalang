<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubscribeRequest;
use App\Models\Subscribe;

class SubscribeController extends Controller
{
    public function __invoke(SubscribeRequest $request)
    {
        $validated = $request->validated();

        Subscribe::create($validated);

        $message = isset($validated['website']) 
            ? 'Uğurlu! Vebsayt auditi üçün sorğunuz qeydə alındı. Hesabat emailinizə göndəriləcək.' 
            : __('front.messages.subscribe_success', ['email' => $validated['mail']]);

        if ($request->expectsJson()) {
            return response()->json([
                'status' => 201,
                'message' => $message,
            ], 201);
        }

        return back()->with('success', $message);
    }
}
