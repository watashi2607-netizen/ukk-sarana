<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSiswa
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is logged in as siswa
        if (!session()->has('user') || !session()->has('user_type') || session('user_type') !== 'siswa') {
            return redirect('/login')->with('error', 'Silakan login sebagai siswa terlebih dahulu.');
        }

        return $next($request);
    }
}
