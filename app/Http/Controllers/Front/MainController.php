<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Blog;
use App\Models\Company;
use App\Models\Pcategory;
use App\Models\Portfolio;
use App\Models\Service;

class MainController extends Controller
{
    public function index()
    {
        if(!config('app.env')  == 'local'){
           return view('coming-soon');
        }
        $main_services = Service::where('in_main', 1)->where('parent_id', 0)->get();

        $portfolios = Portfolio::where('in_main', 1)->with('pcategories')->get();

        $pcategory = $portfolios->pluck('id')->toArray();
        $portfolio_categories = Pcategory::whereHas('portfolios', function ($query) use ($pcategory) {
            $query->whereIn('pcategory_portfolio.portfolio_id', $pcategory);
        })->get();
        $banner = Banner::first();
        $companies = Company::all();
        $blogs = Blog::all();

        return view('front.index.index', compact('main_services', 'portfolio_categories', 'portfolios', 'companies', 'blogs', 'banner'));
    }
}
