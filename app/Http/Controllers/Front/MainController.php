<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Company;
use App\Models\Pcategory;
use App\Models\Portfolio;
use App\Models\Service;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index(){
        $main_services  = Service::where('in_main',1)->where('parent_id',0)->get();
        $portfolios = Portfolio::where('in_main',1)->with('pcategories')->get();

        $pcategory = $portfolios->pluck('id')->toArray();
        $portfolio_categories = Pcategory::whereHas('portfolios', function($query) use($pcategory) {
            $query->whereIn('pcategory_portfolio.portfolio_id',$pcategory);
        })->get();

        $companies = Company::all();
        $blogs = Blog::all();
        return view('front.index' ,compact('main_services', 'portfolio_categories', 'portfolios', 'companies','blogs'));
    }
}
