<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;

class ApplicationController extends Controller
{
    /**
     * Display a listing of the applications.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $company = Auth::user()->company;
        
        // Get all applications for jobs posted by this company
        $applications = Application::whereHas('job', function ($query) use ($company) {
            $query->where('company_id', $company->id);
        })->with(['job', 'user'])->latest()->paginate(10);
        
        return view('company.applications.index', compact('applications'));
    }

    /**
     * Approve an application.
     *
     * @param  \App\Models\Application  $application
     * @return \Illuminate\Http\RedirectResponse
     */
    public function approve(Application $application)
    {
        // Check if the application belongs to a job from this company
        $this->authorize('update', $application);
        
        $application->status = 'approved';
        $application->save();
        
        // إشعار الطالب بالقبول
        Notification::create([
            'user_id' => $application->user_id,
            'title' => 'Application Approved',
            'message' => 'Your application for the opportunity "' . ($application->job->title ?? '') . '" has been approved.',
            'type' => 'success',
        ]);
        
        return back()->with('success', 'Application approved successfully.');
    }

    /**
     * Reject an application.
     *
     * @param  \App\Models\Application  $application
     * @return \Illuminate\Http\RedirectResponse
     */
    public function reject(Application $application)
    {
        // Check if the application belongs to a job from this company
        $this->authorize('update', $application);
        
        $application->status = 'rejected';
        $application->save();
        
        // إشعار الطالب بالرفض
        Notification::create([
            'user_id' => $application->user_id,
            'title' => 'Application Rejected',
            'message' => 'Your application for the opportunity "' . ($application->job->title ?? '') . '" has been rejected.',
            'type' => 'error',
        ]);
        
        return back()->with('success', 'Application rejected successfully.');
    }
}
