<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // jika user tidak sesuai role, redirect ke dashboard sesuai role
        if (!auth()->user()->hasRole($role)) {
            if (auth()->user()->hasRole('admin')) {
                return redirect()->route('admin.dashboard');
            } elseif (auth()->user()->hasRole('wali')) {
                return redirect()->route('wali.dashboard');
            } elseif (auth()->user()->hasRole('siswa')) {
                return redirect()->route('siswa.dashboard');
            }
            abort(403); // akses ditolak
        }

        return $next($request);
    }
}
