<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah user adalah admin dan sudah login
        if (Auth::guard('admin')->check()) {
            return $next($request);
        }

        // Jika bukan admin, redirect ke login admin
        return redirect()->route('admin.login')->with('error', 'Anda harus login sebagai admin.');
    }
}