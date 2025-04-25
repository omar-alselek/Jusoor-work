<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
// Add potentially needed models
// use App\Models\Job;
// use App\Models\Application;

class CompanyController extends Controller
{
    /**
     * Display the company dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function dashboard()
    {
        $company = Auth::user()->company;

        // Example: Load data for dashboard widgets (replace with your actual logic)
        // $postedJobsCount = Job::where('company_id', $company->id)->count();
        // $applicationsReceivedCount = Application::whereIn('job_id', $company->jobs()->pluck('id'))->count();
        // $profileCompletionPercentage = $this->calculateProfileCompletion($company); // Implement this method
        // $recentJobs = Job::where('company_id', $company->id)->latest()->take(3)->get();

        return view('company.dashboard', [
            // Pass data to the view
            // 'postedJobsCount' => $postedJobsCount,
            // 'applicationsReceivedCount' => $applicationsReceivedCount,
            // 'profileCompletionPercentage' => $profileCompletionPercentage,
            // 'recentJobs' => $recentJobs,
        ]);
    }

    public function uploadDocuments(Request $request)
    {
        $request->validate([
            'additional_document' => ['sometimes', 'required', 'file', 'mimes:pdf,jpg,png', 'max:2048'],
        ]);

        $company = Auth::user()->company;

        if ($request->hasFile('additional_document')) {
            $path = $request->file('additional_document')->store('company_documents/' . $company->id, 'public');
            $additionalDocuments = $company->additional_documents ?? [];
            $additionalDocuments[] = $path;
            $company->additional_documents = $additionalDocuments;
            $company->save();

            return back()->with('success', 'Additional document uploaded successfully.');
        }

        return back()->with('error', 'No document was uploaded.');
    }

    // Example helper method (implement based on your criteria)
    /*
    private function calculateProfileCompletion($company)
    {
        $totalFields = 5; // Adjust based on fields you consider for completion
        $filledFields = 0;
        if (!empty($company->company_name)) $filledFields++;
        if (!empty($company->field_of_work)) $filledFields++;
        if (!empty($company->company_size)) $filledFields++;
        if (!empty($company->location)) $filledFields++;
        if (!empty($company->company_email)) $filledFields++;
        // Add checks for logo, etc.

        return $totalFields > 0 ? round(($filledFields / $totalFields) * 100) : 0;
    }
    */
} 