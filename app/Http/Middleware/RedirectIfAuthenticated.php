<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::guard($guard)->user();
                
                // Redirect ke dashboard sesuai role dengan pesan
                switch ($user->role) {
                    case 'admin':
                        return redirect()->route('admin.dashboard')
                            ->with('info', 'Anda sudah login sebagai Admin.');
                    case 'penjual':
                        return redirect()->route('seller.dashboard')
                            ->with('info', 'Anda sudah login sebagai Penjual.');
                    case 'customer':
                        return redirect()->route('customer.dashboard')
                            ->with('info', 'Anda sudah login sebagai Customer.');
                    default:
                        // Jika role tidak valid, logout
                        Auth::logout();
                        $request->session()->invalidate();
                        $request->session()->regenerateToken();
                        return redirect()->route('login')
                            ->with('error', 'Role tidak valid. Silakan login ulang.');
                }
            }
        }

        return $next($request);
    }
}