<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        // Jika request adalah AJAX atau API, return null (akan throw 401)
        if ($request->expectsJson()) {
            return null;
        }

        // Redirect ke login page dengan pesan
        return route('login');
    }

    /**
     * Handle an unauthenticated user.
     */
    protected function unauthenticated($request, array $guards)
    {
        if ($request->expectsJson()) {
            return response()->json([
                'error' => 'Unauthorized',
                'message' => 'Silakan login terlebih dahulu untuk mengakses halaman ini.'
            ], 401);
        }

        return redirect()->route('login')
            ->with('error', 'Silakan login terlebih dahulu untuk mengakses halaman ini.');
    }
}