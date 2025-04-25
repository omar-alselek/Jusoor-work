<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobSeekerMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check() || !Auth::user()->isJobSeeker()) {
            return redirect()->route('login')->with('error', 'Unauthorized access. Job seeker access only.');
        }

        return $next($request);
    }
} 