<?php

namespace App\Http\Controllers\Base;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class Language_Controller extends Controller
{
    public function switchLanguage($locale)
    {
        $languages = config('languages');
        if (array_key_exists($locale, $languages)) {
            App::setLocale($locale);
            session()->put('locale', $locale);
            return redirect()->back();
        } else {
            // Handle the case where the locale is not available
            dd("Language not available!");
        }
    }
}
