<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Portfolio;
use App\Models\Blog;
use App\Models\Message;
use App\Models\CaseStudy;
use App\Models\Testimonial;
use App\Models\Partner;
use App\Models\TeamMember;
use Illuminate\Http\Request;
use App\Models\Setting;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'services' => Service::count(),
            'portfolios' => Portfolio::count(),
            'blogs' => Blog::count(),
            'messages' => Message::count(),
            'case_studies' => CaseStudy::count(),
            'testimonials' => Testimonial::count(),
            'partners' => Partner::count(),
            'team_members' => TeamMember::count(),
            'users' => \App\Models\User::count(),
            'roles' => \Spatie\Permission\Models\Role::count(),
        ];

        $latestMessages = Message::latest()->take(5)->get();
        $latestBlogs = Blog::latest()->take(5)->get();

        $userId = auth()->id();
        $layoutKey = $userId ? 'dashboard_layout_user_' . $userId : 'dashboard_layout';
        $savedLayout = Setting::where('key', $layoutKey)->value('value');
        if (!$savedLayout) {
            $savedLayout = Setting::where('key', 'dashboard_layout')->value('value');
        }
        $layoutOrder = $savedLayout ? json_decode($savedLayout, true) : [];

        $topLayoutKey = $userId ? 'dashboard_layout_top_user_' . $userId : 'dashboard_layout_top';
        $savedTopLayout = Setting::where('key', $topLayoutKey)->value('value');
        if (!$savedTopLayout) {
            $savedTopLayout = Setting::where('key', 'dashboard_layout_top')->value('value');
        }
        $topLayoutOrder = $savedTopLayout ? json_decode($savedTopLayout, true) : [];

        return view('admin.index', compact('stats', 'latestMessages', 'latestBlogs', 'layoutOrder', 'topLayoutOrder'));
    }

    public function updateLayout(Request $request)
    {
        $order = $request->input('order');
        if (is_array($order)) {
            $userId = auth()->id();
            $area = $request->input('area', 'main');
            if (!in_array($area, ['main', 'top'], true)) {
                $area = 'main';
            }
            $layoutBaseKey = $area === 'top' ? 'dashboard_layout_top' : 'dashboard_layout';
            $layoutKey = $userId ? $layoutBaseKey . '_user_' . $userId : $layoutBaseKey;
            Setting::updateOrCreate(
                ['key' => $layoutKey],
                ['value' => json_encode($order)]
            );
        }

        return response()->json(['success' => true]);
    }
}
