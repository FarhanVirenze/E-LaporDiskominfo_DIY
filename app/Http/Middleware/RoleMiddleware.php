<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        // Pastikan user login
        if (!Auth::check()) {
            return redirect()->route('login'); // atau halaman login kamu
        }

        // Cek role user
        if (Auth::user()->role === $role) {
            return $next($request);
        }

        // Jika role tidak sesuai → tampilkan error
        return response()->view('errors.akses-ditolak', [], 403);
    }
}
