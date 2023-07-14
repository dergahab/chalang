<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Database\Query\Builder;

class ServiceController extends Controller
{
    public function index()
    {
        $items = Service::where('parent_id', 0)->with('childs')->get();

        return view('front.services.services', compact('items'));
    }

    public function details($slug)
    {
        $item = Service::orWhereTranslationLike('slug', '%' . $slug . '%')->first();

        return view('front.services.single', compact('item'));
    }
}
