<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check() || !Auth::user()->isCompany()) {
            return redirect()->route('login')->with('error', 'Unauthorized access. Company access only.');
        }

        return $next($request);
    }
} 