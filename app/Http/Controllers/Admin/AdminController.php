<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\CompanyApprovalEmail;
use App\Mail\CompanyRejectionEmail;

class AdminController extends Controller
{
    public function dashboard()
    {
        $pendingCompanies = Company::where('status', 'pending')->get();
        $users = User::where('role', '!=', 'admin')->get();
        
        return view('admin.dashboard', compact('pendingCompanies', 'users'));
    }

    public function approveCompany(Company $company)
    {
        $company->update(['status' => 'approved']);
        
        // Get the associated user
        $user = $company->user;
        
        // Send approval email
        Mail::to($user->email)->send(new CompanyApprovalEmail($user));
        
        return redirect()->back()->with('success', 'Company approved successfully. An email has been sent to the company.');
    }

    public function rejectCompany(Request $request, Company $company)
    {
        $request->validate([
            'rejection_reason' => ['required', 'string', 'min:10'],
        ]);

        $company->update([
            'status' => 'rejected',
            'rejection_reason' => $request->rejection_reason,
        ]);

        // Get the associated user
        $user = $company->user;
        
        // Send rejection email
        Mail::to($user->email)->send(new CompanyRejectionEmail($user, $request->rejection_reason));

        return redirect()->back()->with('success', 'Company rejected successfully. An email has been sent to the company.');
    }

    public function blockUser(User $user)
    {
        $user->update(['is_blocked' => true]);
        return redirect()->back()->with('success', 'User blocked successfully.');
    }

    public function unblockUser(User $user)
    {
        $user->update(['is_blocked' => false]);
        return redirect()->back()->with('success', 'User unblocked successfully.');
    }

    public function deleteUser(User $user)
    {
        $user->delete();
        return redirect()->back()->with('success', 'User deleted successfully.');
    }
} 