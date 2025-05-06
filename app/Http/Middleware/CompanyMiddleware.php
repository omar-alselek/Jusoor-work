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

        // منع الشركة من رؤية أي صفحة إذا كانت حالتها pending أو rejected
        $company = Auth::user()->company;
        if ($company && in_array($company->status, ['pending', 'rejected']) && !$request->is('company/waiting-approval')) {
            return redirect()->route('company.waiting_approval');
        }

        return $next($request);
    }
} 