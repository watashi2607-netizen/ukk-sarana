<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Guest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (session('user') && session('user_type')) {
            // Jika sudah login sebagai admin, redirect ke dashboard admin
            if (session('user_type') === 'admin') {
                return redirect()->route('admin.dashboard');
            }
            // Jika sudah login sebagai siswa, redirect ke dashboard siswa
            elseif (session('user_type') === 'siswa') {
                return redirect()->route('siswa.dashboard');
            }
        }

        return $next($request);
    }
}