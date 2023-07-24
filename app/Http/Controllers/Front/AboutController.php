<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\About;
use App\Models\Step;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function __invoke()
    {
        $item = About::first();
        $steps = Step::all();
        return view('front.about',compact('item','steps'));
    }
}
