<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Bcategory;
use App\Models\Blog;

class BlogController extends Controller
{
    public function __construct()
    {
        view()->share('categories', Bcategory::all());
    }

    public function index()
    {
        $data = Blog::paginate(10); // Replace 10 with the number of records per page you want to display
       
        return view('front.blogs.blog', compact('data'));
    }

    public function single($slug)
    {
        $item = Blog::where('slug', $slug)->first();

        return view('front.blogs.single', compact('item'));
    }
}
