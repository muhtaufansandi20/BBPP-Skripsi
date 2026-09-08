<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth; 

class KepalaBalai
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
       // Periksa apakah pengguna terautentikasi dan memiliki role 'kepalabalai'
       if (Auth::check() && Auth::user()->role === 'kepalabalai') {
        return $next($request);
    }

    // Jika tidak, redirect atau berikan response error
    return redirect('/')->with('error', 'Anda tidak memiliki akses sebagai Kepala Balai.');
    }
}
