<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class setLocale
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->route()->getName() !== 'lang.switch') {
            if (session()->has('locale')) {
                app()->setLocale(session()->get('locale'));
            }
        }

        return $next($request);
    }
}
