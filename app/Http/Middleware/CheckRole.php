<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$role): Response
    {
        if (in_array($request->user()->role, $role)) {
            return $next($request);
        }

        // Jika bukan admin yang mencoba akses admin page, redirect ke dashboard
        return redirect()->route('dashboard')
            ->with('error', 'Anda tidak memiliki akses ke halaman admin.');
    }
}
