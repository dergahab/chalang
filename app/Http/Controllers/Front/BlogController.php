<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Bcategory;
use App\Models\Blog;

class BlogController extends Controller
{
    public function __construct()
    {
        // Don't load any data in constructor - it runs during route gathering
        // Data will be loaded in methods as needed
    }

    public function index()
    {
        $data = Blog::paginate(10);
        $categories = Bcategory::all();
       
        return view('front.blogs.blog', compact('data', 'categories'));
    }

    public function single($slug)
    {
        $item = Blog::whereTranslation('slug', $slug)->first();
        $categories = Bcategory::all();

        return view('front.blogs.single', compact('item', 'categories'));
    }

    public function newIndex()
    {
        $data = Blog::paginate(10);
        $categories = Bcategory::all();
       
        return view('front.blogs.blog_new', compact('data', 'categories'));
    }

    public function newSingle(Blog $blog)
    {
        $categories = Bcategory::all();

        return view('front.blogs.single_new', ['item' => $blog, 'categories' => $categories]);
    }
}
