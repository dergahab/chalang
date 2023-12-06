<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller {
    public function index() {
        $messages = Message::all();
        return view("admin.pages.message.index", compact('messages'));
    }
}