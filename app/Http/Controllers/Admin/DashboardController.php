<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        // $this->canOrAbort('test');
        return view('admin.index');
    }
}
