<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceContentOption;
use App\Models\ServisContent;
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
        $content = ServisContent::where('service_id', $item?->id)->first();
        return view('front.services.single', compact('item', 'content'));
    }
}
