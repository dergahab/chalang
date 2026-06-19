<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\TeamMember;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function index()
    {
        $team_members = TeamMember::orderBy('sort_order')->get();
        return view('front.pages.team.index', compact('team_members'));
    }
}
