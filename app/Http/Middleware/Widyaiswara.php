<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class Widyaiswara
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Periksa apakah pengguna terautentikasi dan memiliki role 'widyaiswara'
        if (Auth::check() && Auth::user()->role === 'widyaiswara') {
            return $next($request);
        }

        // Jika tidak, redirect dengan pesan error
        return redirect('/')->with('error', 'Anda tidak memiliki akses sebagai Widyaiswara.');
    }
}
