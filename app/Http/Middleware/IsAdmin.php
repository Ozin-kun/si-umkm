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
        $user = auth()->user();

        // Cek apakah user sudah login dan berperan sebagai Admin Desa
        if (auth()->check() && (
            $user->role_id == 1 ||
            $user->role?->name === 'Admin Desa'
        )) {
            return $next($request);
        }

        // Jika bukan admin, tolak aksesnya
        abort(403, 'Akses Ditolak. Halaman ini khusus Admin Desa.');
    }
}
