<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsUmkm
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        // Cek apakah user sudah login dan berperan sebagai Pelaku UMKM
        if (auth()->check() && (
            $user->role_id == 2 ||
            $user->role?->name === 'Pelaku UMKM'
        )) {
            return $next($request);
        }

        abort(403, 'Akses Ditolak. Halaman ini khusus Pelaku UMKM.');
    }
}
