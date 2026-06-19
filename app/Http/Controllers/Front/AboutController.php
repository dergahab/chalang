<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\About;
use App\Models\Step;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function __invoke()
    {
        $item = About::first();
        $steps = Step::all();
        $teamMembers = \App\Models\TeamMember::where('is_featured', true)->get();
        $partners = \App\Models\Partner::where('is_active', true)->get();
        return view('front.about',compact('item','steps', 'teamMembers', 'partners'));
    }

    public function newVersion()
    {
        $item = About::first();
        $steps = Step::all();
        $teamMembers = \App\Models\TeamMember::where('is_featured', true)->get();
        $partners = \App\Models\Partner::where('is_active', true)->get();
        
        // Footer dependencies
        $main_services = \App\Models\Service::where('status', 1)->take(5)->get();
        $socialmedia = \App\Models\Socialmedia::all();

        return inertia('About', [
            'main_services' => $main_services,
            'socialmedia' => $socialmedia,
            // Navbar/Footer shared data
            'translations' => [
                'nav' => __('preview.nav'),
                'footer' => __('preview.footer'),
            ],
            'global_settings' => \App\Models\Setting::pluck('value', 'key')->toArray(),
            'theme' => [
                'colors' => [
                    'light' => [
                        'primary' => 'var(--brand-primary)',
                        'secondary' => 'var(--brand-secondary)',
                        'primary_rgb' => '75, 0, 130',
                        'secondary_rgb' => '213, 0, 249',
                    ],
                    'dark' => [
                        'primary' => 'var(--brand-primary)',
                        'secondary' => 'var(--brand-secondary)',
                        'primary_rgb' => '75, 0, 130',
                        'secondary_rgb' => '213, 0, 249',
                    ],
                ],
                'font' => 'Inter',
                'font_url' => 'Inter:wght@300;400;500;600;700;800',
                'border_radius' => '1rem',
                'radii' => [
                    'btn' => '50px',
                    'card' => '30px',
                    'input' => '16px'
                ],
                'smart_bg' => true,
                'glow_intensity' => 15,
                'custom_css' => '',
                'custom_js' => '',
            ],

            // Page-specific data
            'about' => [
                'id' => $item?->id,
                'title' => $item?->title,
                'description' => $item?->description,
                'image' => $item?->image ? 'storage/' . $item->image : null,
            ],
            'steps' => $steps->map(fn($s) => [
                'id' => $s->id,
                'title' => $s->title,
                'description' => strip_tags($s->description),
                'icon' => $s->icon,
                'image' => $s->image ? 'storage/' . $s->image : null,
            ])->toArray(),
            'teamMembers' => $teamMembers->map(fn($m) => [
                'id' => $m->id,
                'name' => $m->name,
                'position' => $m->position,
                'image' => $m->image ? 'storage/' . $m->image : null,
                'social_links' => is_array($m->social_links) 
                    ? $m->social_links 
                    : json_decode($m->social_links ?? '{}', true),
            ])->toArray(),
            'partners' => $partners->map(fn($p) => [
                'id' => $p->id,
                'name' => $p->name,
                'logo' => $p->logo ? 'storage/' . $p->logo : null,
            ])->toArray(),
            // Shared translations and Page-specific data
            'translations' => [
                'nav' => __('preview.nav'),
                'footer' => __('preview.footer'),
                'banner' => [
                    'title' => __('front.banner.title'),
                    'description' => __('front.banner.description'),
                ],
                'who_we_are' => __('who_we_are'),
                'process' => __('front.about.process'),
                'logo_design_process' => __('front.about.logo_design_process'),
                'years_on_market' => __('front.about.years_on_market'),
            ],
        ]);
    }
}
