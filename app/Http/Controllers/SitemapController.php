<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Portfolio;
use App\Models\Service;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    /**
     * Generate dynamic sitemap.xml
     */
    public function index(): Response
    {
        $services = Service::where('parent_id', '!=', null)->get(); // Only sub-services
        $portfolios = Portfolio::all();
        $blogs = Blog::all();

        return response()->view('front.sitemap', [
            'services' => $services,
            'portfolios' => $portfolios,
            'blogs' => $blogs,
        ])->header('Content-Type', 'text/xml');
    }
}
