<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LanguageController extends Controller
{
    /** All locales the switcher exposes. Add more as translation files are added. */
    public const SUPPORTED = [
        'en' => ['name' => 'English',    'flag' => '🇺🇸', 'dir' => 'ltr'],
        'ar' => ['name' => 'العربية',    'flag' => '🇸🇦', 'dir' => 'rtl'],
        'fr' => ['name' => 'Français',   'flag' => '🇫🇷', 'dir' => 'ltr'],
        'es' => ['name' => 'Español',    'flag' => '🇪🇸', 'dir' => 'ltr'],
        'de' => ['name' => 'Deutsch',    'flag' => '🇩🇪', 'dir' => 'ltr'],
        'zh' => ['name' => '中文',        'flag' => '🇨🇳', 'dir' => 'ltr'],
        'ja' => ['name' => '日本語',      'flag' => '🇯🇵', 'dir' => 'ltr'],
        'pt' => ['name' => 'Português',  'flag' => '🇧🇷', 'dir' => 'ltr'],
        'hi' => ['name' => 'हिन्दी',       'flag' => '🇮🇳', 'dir' => 'ltr'],
        'ru' => ['name' => 'Русский',    'flag' => '🇷🇺', 'dir' => 'ltr'],
        'tr' => ['name' => 'Türkçe',     'flag' => '🇹🇷', 'dir' => 'ltr'],
        'ko' => ['name' => '한국어',      'flag' => '🇰🇷', 'dir' => 'ltr'],
        'it' => ['name' => 'Italiano',   'flag' => '🇮🇹', 'dir' => 'ltr'],
    ];

    public function switch(Request $request, string $locale)
    {
        if (array_key_exists($locale, self::SUPPORTED)) {
            session(['locale' => $locale]);
        }
        // Use url()->previous() with a safe fallback so we never redirect to
        // a page that no longer exists (e.g. a deleted product).
        $fallback = route('shop.index');
        return redirect(url()->previous($fallback))->withHeaders([
            'Cache-Control' => 'no-store',
        ]);
    }
}
