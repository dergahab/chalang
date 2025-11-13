<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Contact;

class ContactController extends Controller
{
    public function __invoke()
    {
        $contact = Contact::first();

        return view('front.contuct-us', compact('contact'));
    }
}
