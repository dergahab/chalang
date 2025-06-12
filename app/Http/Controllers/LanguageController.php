<?php

namespace App\Http\Controllers;

use App\Models\Lang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    public function changeLanguage(Request $request, $lang)
    {
        $languages = ['az', 'ru', 'en'];
        if (in_array($lang, $languages)) {
            Session::put('lang', $lang);
            app()->setLocale($lang);
        }
        return redirect()->back();
    }
}
