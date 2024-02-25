<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRolMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, $rol)
    {
        if (Auth::user()->rol === $rol) {
            return $next($request);
        } else if ($request->expectsJson()) {
                return response()->json(['error' => 'No autorizado'], 401);
        } else {
            return redirect('/login');
        }
    }
}
