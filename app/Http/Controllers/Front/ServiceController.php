<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Service;

class ServiceController extends Controller
{
    public function index()
    {
        $items = Service::where('parent_id', 0)->with('childs')->get();
        $testimonials = \App\Models\Testimonial::where('is_active', true)->get();
        $pricingPlans = \App\Models\PricingPlan::where('is_active', true)->get();

        return view('front.services.services', compact('items', 'testimonials', 'pricingPlans'));
    }

    public function details($slug)
    {
        $item = Service::with(['serviceContent', 'caseStudies', 'faqs', 'testimonials' => function($q) {
            $q->where('is_active', 1)->orderBy('sort_order');
        }])->whereTranslation('slug', $slug)->firstOrFail();

        return view('front.services.single', [
            'item' => $item,
            'content' => $item->serviceContent,
        ]);
    }

    public function newIndex()
    {
        $items = Service::where('parent_id', 0)->with('childs')->get();
        $testimonials = \App\Models\Testimonial::where('is_active', true)->get();
        $pricingPlans = \App\Models\PricingPlan::where('is_active', true)->get();

        return view('front.services.services_new', compact('items', 'testimonials', 'pricingPlans'));
    }

    public function newDetails($slug)
    {
        $item = Service::with(['serviceContent', 'caseStudies', 'faqs', 'testimonials' => function($q) {
            $q->where('is_active', 1)->orderBy('sort_order');
        }])->whereTranslation('slug', $slug)->firstOrFail();

        return view('front.services.single_new', [
            'item' => $item,
            'content' => $item->serviceContent,
        ]);
    }
}
