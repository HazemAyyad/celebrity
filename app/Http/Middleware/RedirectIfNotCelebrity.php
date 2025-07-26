<?php

namespace App\Http\Middleware;


use Closure;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfNotCelebrity
{
    public function handle($request, Closure $next): Response
    {
        if (!Auth::guard('celebrity')->check()) {
            return redirect()->route('celebrity.login');
        }

        return $next($request);
    }
}
