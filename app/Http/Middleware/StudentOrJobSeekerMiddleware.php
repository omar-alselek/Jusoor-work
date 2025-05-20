<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class StudentOrJobSeekerMiddleware
{
    public function handle($request, Closure $next)
    {
        if (!Auth::check() || (!Auth::user()->isStudent() && !Auth::user()->isJobSeeker())) {
            return redirect()->route('login')->with('error', 'Unauthorized access.');
        }
        return $next($request);
    }
} 