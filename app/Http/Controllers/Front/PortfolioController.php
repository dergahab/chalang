<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Pcategory;
use App\Models\Portfolio;
use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    public function index(){

    $portfolios = Portfolio::with('pcategories')->get();

    $pcategory = $portfolios->pluck('id')->toArray();
    $portfolio_categories = Pcategory::whereHas('portfolios', function($query) use($pcategory) {
        $query->whereIn('pcategory_portfolio.portfolio_id',$pcategory);
    })->get();
    return view('front.portfolio.portfolio', compact('portfolio_categories', 'portfolios'));
    }


    public function details($slug)
    {
        return view('front.portfolio.single');
    }
}
