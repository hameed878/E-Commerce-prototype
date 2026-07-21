<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        $locale = session('locale', 'en');
        if (array_key_exists($locale, \App\Http\Controllers\LanguageController::SUPPORTED)) {
            App::setLocale($locale);
        }
        return $next($request);
    }
}
