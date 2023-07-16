<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\About;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function __invoke()
    {
        $item = About::first();
        return view('front.about',compact('item'));
    }
}
