<?php

namespace App\Services;

use App\Models\Banner;
use App\Models\Blog;
use App\Models\Company;
use App\Models\Contenttext;
use App\Models\Pcategory;
use App\Models\Portfolio;
use App\Models\Service;
use App\Models\Step;

class FrontService
{
    public function getMainServices()
    {
        return Service::where('in_main', 1)
            ->where('parent_id', 0)
            ->with(['childs' => function ($q) {
                $q->where('status', 1)->orderBy('id');
            }, 'childs.translations'])
            ->get();
    }

    public function getPortfolios($limit = null)
    {
        $query = Portfolio::with(['pcategories', 'translations', 'pcategories.translations']);
        
        if ($limit) {
            $query->latest()->take($limit);
        } else {
            $query->where('in_main', 1);
        }

        return $query->get();
    }

    public function getPortfolioCategories($portfolios)
    {
        $pcategoryIds = $portfolios->pluck('id')->toArray();
        
        return Pcategory::whereHas('portfolios', function ($query) use ($pcategoryIds) {
            $query->whereIn('pcategory_portfolio.portfolio_id', $pcategoryIds);
        })->get();
    }

    public function getBanner()
    {
        return Banner::first();
    }

    public function getCompanies()
    {
        return Company::all();
    }

    public function getBlogs($limit = null, $onlyActive = false)
    {
        $query = Blog::with('translations');

        if ($onlyActive) {
            $query->where('status', 1);
        }

        if ($limit) {
            $query->latest()->take($limit);
        }

        return $query->get();
    }

    public function getCaseStudies($limit = null)
    {
        $query = \App\Models\CaseStudy::where('in_main', 1)->orderBy('sort_order');
        if ($limit) {
            $query->take($limit);
        }
        return $query->get();
    }

    public function getTestimonials($limit = null)
    {
        $query = \App\Models\Testimonial::with('translations')->where('is_active', 1)->orderBy('sort_order');
        if ($limit) {
            $query->take($limit);
        }
        return $query->get();
    }

    public function getPartners()
    {
        return \App\Models\Partner::where('is_active', 1)->orderBy('sort_order')->get();
    }

    public function getPricingPlans()
    {
        return \App\Models\PricingPlan::where('is_active', 1)->orderBy('sort_order')->get();
    }

    public function getTeamMembers($featured = false)
    {
        $query = \App\Models\TeamMember::with('translations')->orderBy('sort_order');
        if ($featured) {
            $query->where('is_featured', 1);
        }
        return $query->get();
    }

    public function getFaqs($limit = null)
    {
        $query = \App\Models\Faq::with('translations')->where('is_active', 1)->orderBy('sort_order');
        if ($limit) {
            $query->take($limit);
        }
        return $query->get();
    }

    public function getSteps($limit = null)
    {
        $query = Step::orderBy('position');
        if ($limit) {
            $query->take($limit);
        }
        return $query->get();
    }

    public function getAbout()
    {
        return \App\Models\About::first();
    }

    public function getContentTexts(array $keys = [], array $prefixes = [])
    {
        $query = Contenttext::with('translations');

        $query->where(function ($q) use ($keys, $prefixes) {
            if ($keys) {
                $q->whereIn('key', $keys);
            }
            if ($prefixes) {
                foreach ($prefixes as $prefix) {
                    $q->orWhere('key', 'like', $prefix . '%');
                }
            }
        });

        return $query->get();
    }
}
