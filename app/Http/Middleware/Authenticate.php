<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string|null  $guard
     */
    public function handle(Request $request, Closure $next, $guard = null): Response
    {
        if (Auth::guard($guard)->check()) {
            return $next($request);
        }

        // Redirect ke halaman login berdasarkan guard
        if ($guard == 'admin') {
            return redirect()->route('admin.login');
        }

        // Untuk guard user biasa, redirect ke login user (jika ada)
        return redirect()->route('login');
    }
}