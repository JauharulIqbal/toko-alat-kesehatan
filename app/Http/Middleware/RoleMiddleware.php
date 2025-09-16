<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Periksa apakah user sudah login
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = Auth::user();

        // Periksa apakah user memiliki role yang diizinkan
        if (!in_array($user->role, $roles)) {
            // Log unauthorized access attempt
            Log::warning('Unauthorized access attempt', [
                'user_id' => $user->id_user ?? $user->id,
                'user_role' => $user->role,
                'required_roles' => $roles,
                'requested_url' => $request->url(),
                'ip' => $request->ip()
            ]);

            // Redirect berdasarkan role user yang sebenarnya
            switch ($user->role) {
                case 'admin':
                    return redirect()->route('admin.dashboard')
                        ->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
                case 'penjual':
                    return redirect()->route('seller.dashboard')
                        ->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
                case 'customer':
                    return redirect()->route('customer.dashboard')
                        ->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
                default:
                    Auth::logout();
                    return redirect()->route('login')
                        ->with('error', 'Role tidak valid. Silakan login kembali.');
            }
        }

        return $next($request);
    }
}