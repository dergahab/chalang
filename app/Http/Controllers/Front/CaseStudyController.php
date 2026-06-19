<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\CaseStudy;
use Illuminate\Http\Request;

class CaseStudyController extends Controller
{
    public function index()
    {
        $case_studies = CaseStudy::orderBy('sort_order')->paginate(9);
        return view('front.pages.case-study.index', compact('case_studies'));
    }

    public function show($slug)
    {
        $case_study = CaseStudy::with('services')->whereTranslation('slug', $slug)->firstOrFail();
        return view('front.pages.case-study.show', compact('case_study'));
    }
}
