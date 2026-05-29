<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Jika belum login, tendang ke login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Ambil data role dan hilangkan spasi tersembunyi
        $userRole = trim(Auth::user()->role);

        // Jika role di database TIDAK SAMA dengan role di web.php
        if ($userRole !== trim($role)) {

            // Jika dia admin tapi nyasar, kembalikan ke tempat admin
            if ($userRole === 'admin') {
                return redirect()->route('admin.dashboard');
            }

            // Jika dia pendaki tapi nyasar, kembalikan ke tempat pendaki
            if ($userRole === 'pendaki') {
                return redirect()->route('dashboard');
            }

            // Jika role tidak dikenali sama sekali
            abort(403, 'Akses ditolak.');
        }

        return $next($request);
    }
}
