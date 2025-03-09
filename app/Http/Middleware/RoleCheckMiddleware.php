<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleCheckMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles){
        foreach ($roles as $role) {
            if (Auth::guard()->check() && Auth::guard()->user()->role == $role) {
                return $next($request);
            }
        }
        Auth::guard()->logout();
        return redirect()->route('login')->with('status','You are not authorized to access this page.');
    }
}
