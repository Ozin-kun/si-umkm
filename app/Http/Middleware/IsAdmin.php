<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah user sudah login dan role_id = 1 (Admin Desa)
        if (auth()->check() && auth()->user()->role_id == 1) {
            return $next($request);
        }

        // Jika bukan admin, tolak aksesnya
        abort(403, 'Akses Ditolak. Halaman ini khusus Admin Desa.');
    }
}
