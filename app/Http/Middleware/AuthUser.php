<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthUser
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::guard('web')->check()) {
            return redirect()->route('user.login');
        }

        if (!Auth::guard('web')->user()->hasVerifiedEmail()) {
            return redirect()->route('user.verification.notice');
        }

        return $next($request);
    }
}
