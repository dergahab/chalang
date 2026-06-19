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
        Log::info('LanguageController Hit with: ' . $lang);

        if (in_array($lang, $languages)) {
            Session::put('lang', $lang);
            Session::save(); // Force save
            App::setLocale($lang);
            Log::info('Language SUCCESSFULLY changed to: ' . $lang . '. Session: ' . Session::get('lang'));
        } else {
            Log::warning('Invalid language requested: ' . $lang);
        }
        return redirect()->back();
    }
}
