<?php

namespace App\Http\Controllers;

use App\Models\Lang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class LanguageController extends Controller
{
    public function changeLanguage(Request $request, $lang)
    {
        $languages = ['az', 'en', 'ru'];
        if (in_array($lang, $languages)) {
            Session::put('lang', $lang);
            App::setLocale($lang);
            Log::info('Language changed to: ' . $lang);
        } else {
            Log::warning('Invalid language requested: ' . $lang);
        }
        return redirect()->back();
    }
}
