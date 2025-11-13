<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Service;

class ServiceController extends Controller
{
    public function index()
    {
        $items = Service::where('parent_id', 0)->with('childs')->get();

        return view('front.services.services', compact('items'));
    }

    public function details($slug)
    {
        $item = Service::with('content')->where(function ($query) use ($slug) {
            $query->where('slug', $slug)
                ->orWhereTranslation('slug', $slug);
        })->firstOrFail();

        return view('front.services.single', [
            'item' => $item,
            'content' => $item->content,
        ]);
    }
}
