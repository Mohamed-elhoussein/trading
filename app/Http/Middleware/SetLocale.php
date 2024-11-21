<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $locale = session('locale', app()->getLocale()); // استخدم اللغة من الجلسة، أو الإنجليزية كـ default
        \Log::info('Locale set to: ' . $locale);
        // تعيين اللغة في التطبيق
        App::setLocale($locale);
        return $next($request);
    }
}
