<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Service;

class ContactController extends Controller
{
    public function __invoke()
    {
        $contact = Contact::first();

        return view('front.contuct-us', compact('contact'));
    }

    public function newVersion()
    {
        $contact = Contact::first();
        $services = Service::where('parent_id', 0)
            ->with(['childs' => function ($query) {
                $query->orderBy('id');
            }])
            ->orderBy('id')
            ->get();

        return view('front.contuct-us_new', compact('contact', 'services'));
    }
}
