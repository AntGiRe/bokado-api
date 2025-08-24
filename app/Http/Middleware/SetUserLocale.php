<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class SetUserLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user('sanctum');

        $requestedLocale = $request->query('locale') ?? $user?->preferred_language ?? 'en';

        $availableLocales = Cache::remember('available_locales', 60, function () {
            return DB::table('languages')
                ->where('is_active', true)
                ->pluck('code')
                ->toArray();
        });

        $locale = in_array($requestedLocale, $availableLocales)
            ? $requestedLocale
            : 'en';

        App::setLocale($locale);

        return $next($request);
    }
}
