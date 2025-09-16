<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PreventCrossRoleAccess
{
    /**
     * Handle an incoming request.
     * Middleware ini mencegah user mengakses dashboard role lain
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        $currentRoute = $request->route()->getName();
        
        // Mapping role dengan route yang diizinkan
        $roleRouteMapping = [
            'admin' => ['admin.'],
            'penjual' => ['seller.'],
            'customer' => ['customer.']
        ];

        // Cek apakah user mencoba mengakses area yang tidak sesuai dengan rolenya
        foreach ($roleRouteMapping as $role => $allowedPrefixes) {
            if ($user->role !== $role) {
                foreach ($allowedPrefixes as $prefix) {
                    if (str_starts_with($currentRoute, $prefix)) {
                        // User mencoba mengakses area yang tidak sesuai dengan rolenya
                        return $this->redirectToCorrectDashboard($user->role);
                    }
                }
            }
        }

        return $next($request);
    }

    /**
     * Redirect user ke dashboard yang sesuai dengan rolenya
     */
    private function redirectToCorrectDashboard($role)
    {
        $message = 'Anda tidak memiliki akses ke halaman tersebut. Dialihkan ke dashboard Anda.';
        
        switch ($role) {
            case 'admin':
                return redirect()->route('admin.dashboard')->with('warning', $message);
            case 'penjual':
                return redirect()->route('seller.dashboard')->with('warning', $message);
            case 'customer':
                return redirect()->route('customer.dashboard')->with('warning', $message);
            default:
                Auth::logout();
                return redirect()->route('login')->with('error', 'Role tidak valid. Silakan login ulang.');
        }
    }
}