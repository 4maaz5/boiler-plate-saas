<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;

class LocaleController extends Controller
{
    public function switch(string $locale): RedirectResponse
    {
        $supportedLocales = config('app.supported_locales', ['en', 'ar']);
        $locale = in_array($locale, $supportedLocales, true)
            ? $locale
            : config('app.fallback_locale', 'en');

        session(['locale' => $locale]);

        return redirect()->back(fallback: url('/admin'));
    }
}
