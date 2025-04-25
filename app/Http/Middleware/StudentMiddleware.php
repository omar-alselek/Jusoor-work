<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check() || !Auth::user()->isStudent()) {
            return redirect()->route('login')->with('error', 'Unauthorized access. Student access only.');
        }

        return $next($request);
    }
} 