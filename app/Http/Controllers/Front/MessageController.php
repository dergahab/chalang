<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function __invoke(Request $request)
    {
        notify()->success('Laravel Notify is awesome!');
        return response()->json([
            'status' => 201,
            'data' => $request->all()
        ]);
    }
}