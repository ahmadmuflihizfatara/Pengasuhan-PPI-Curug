<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     * Usage in routes: ->middleware('role:admin,pengasuh')
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!$request->user()) {
            return redirect()->route('login');
        }

        // Admin memiliki akses penuh ke semua halaman
        if ($request->user()->isAdmin()) {
            return $next($request);
        }

        // Nama akses khusus (kasi_internal, polisi_taruna) boleh dipakai di
        // daftar role rute — taruna yang diberi akses tersebut oleh admin lolos
        // 'duty_taruna' = akses otomatis taruna yang duty minggu ini
        $aksesKhusus = $request->user()->isTaruna() ? ($request->user()->akses_khusus ?? []) : [];
        if (in_array('duty_taruna', $roles) && $request->user()->isDutyTaruna()) {
            $aksesKhusus[] = 'duty_taruna';
        }

        if (!in_array($request->user()->role, $roles) && !array_intersect($roles, $aksesKhusus)) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk halaman ini.');
        }

        return $next($request);
    }
}
