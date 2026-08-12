<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, string ...$guards): Response
{
    $guards = empty($guards) ? [null] : $guards;

    foreach ($guards as $guard) {

        // ✅ KHUSUS ADMIN
        if ($guard === 'admin' && Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }

        // ✅ KHUSUS USER
        if ($guard === 'web' && Auth::guard('web')->check()) {
            return redirect()->route('user.dashboard');
        }
    }

    return $next($request);
}
}
