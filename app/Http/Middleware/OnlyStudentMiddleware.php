<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class OnlyStudentMiddleware
{
    public function handle($request, Closure $next)
    {
        if (!Auth::check() || !Auth::user()->isStudent()) {
            return redirect()->route('student.dashboard')->with('error', 'Training opportunities are only available for students.');
        }
        return $next($request);
    }
} 