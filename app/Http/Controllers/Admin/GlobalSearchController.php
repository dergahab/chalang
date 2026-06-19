<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Portfolio;
use App\Models\Blog;
use App\Models\Page; // Assuming you have a Page model, or similar

class GlobalSearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');
        $results = [];

        if ($query) {
            // Search Services
            $services = Service::whereTranslationLike('name', "%{$query}%")->limit(5)->get();
            foreach ($services as $service) {
                $results[] = [
                    'title' => $service->name,
                    'type' => 'Xidmət',
                    'url' => route('admin.service.edit', $service->id),
                    'icon' => 'ri-service-line'
                ];
            }

            // Search Portfolios
            $portfolios = Portfolio::whereTranslationLike('name', "%{$query}%")->limit(5)->get();
            foreach ($portfolios as $portfolio) {
                $results[] = [
                    'title' => $portfolio->name,
                    'type' => 'Layihə',
                    'url' => route('admin.portfolio.edit', $portfolio->id),
                    'icon' => 'ri-briefcase-line'
                ];
            }

            // Search Blogs
            $blogs = Blog::whereTranslationLike('title', "%{$query}%")->limit(5)->get();
            foreach ($blogs as $blog) {
                $results[] = [
                    'title' => $blog->title,
                    'type' => 'Bloq',
                    'url' => route('admin.blog.edit', $blog->id),
                    'icon' => 'ri-article-line'
                ];
            }
        }

        return response()->json($results);
    }
}
