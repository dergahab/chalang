<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller {
    public function __invoke(Request $request) {

        Message::create($request->all());

        return response()->json([
            'status' => 201,
            'message' => 'İsmarıcınız göndərildi ',
        ]);
    }
}