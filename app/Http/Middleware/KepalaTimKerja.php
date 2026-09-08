<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth; 

class KepalaTimKerja
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Periksa apakah pengguna terautentikasi dan memiliki role 'kepalatimkerja'
        if (Auth::check() && Auth::user()->role === 'kepalatimkerja') {
            return $next($request);
        }

        // Jika tidak, redirect atau berikan response error
        return redirect('/')->with('error', 'Anda tidak memiliki akses sebagai Kepala Tim Kerja.');
    }
}
