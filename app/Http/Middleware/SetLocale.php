<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        if (session()->has('locale')) {
            $locale = session()->get('locale');
            if (array_key_exists($locale, config('app.available_locales', []))) {
                App::setLocale($locale);
            } else {
                // Stale or unknown locale in session (e.g. language removed) — fall back instead of crashing views.
                session()->forget('locale');
                App::setLocale(config('app.locale'));
            }
        }

        return $next($request);
    }
}
