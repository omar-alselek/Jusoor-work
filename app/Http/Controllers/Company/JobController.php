<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobController extends Controller
{
    /**
     * Display a listing of the jobs.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $company = Auth::user()->company;
        $jobs = Job::where('company_id', $company->id)
                  ->orderBy('created_at', 'desc')
                  ->paginate(10);
                  
        return view('company.jobs.index', compact('jobs'));
    }

    /**
     * Show the form for creating a new job.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('company.jobs.create');
    }

    /**
     * Store a newly created job in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:100',
            'description' => 'required|string|max:1000',
            'type' => 'required|string|in:full-time,part-time,internship',
            'location' => 'required|string|max:255',
            'salary' => 'nullable|string|max:255',
            'working_hours' => 'required_if:type,part-time,internship|nullable|string|max:255',
            'required_skills' => 'required|string',
            'requirements' => 'required|string|max:1000',
            'duration' => 'required_if:type,internship|nullable|string|in:1_month,3_months,6_months,capstone',
            'academic_credit' => 'required_if:type,internship|nullable|boolean',
            'start_date' => 'nullable|date|after_or_equal:today',
            'deadline' => 'nullable|date|after:today',
            'benefits' => 'nullable|string|max:500',
        ]);

        $company = Auth::user()->company;
        
        // Convert required_skills string to array
        $validated['required_skills'] = array_map('trim', explode(',', $validated['required_skills']));
        
        $job = new Job($validated);
        $job->company_id = $company->id;
        $job->status = 'active';
        $job->save();

        return redirect()->route('company.jobs.index')
            ->with('success', 'Job posted successfully!');
    }

    /**
     * Display the specified job.
     *
     * @param  \App\Models\Job  $job
     * @return \Illuminate\View\View
     */
    public function show(Job $job)
    {
        $this->authorize('view', $job);
        
        return view('company.jobs.show', compact('job'));
    }

    /**
     * Show the form for editing the specified job.
     *
     * @param  \App\Models\Job  $job
     * @return \Illuminate\View\View
     */
    public function edit(Job $job)
    {
        $this->authorize('update', $job);
        
        return view('company.jobs.edit', compact('job'));
    }

    /**
     * Update the specified job in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Job  $job
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Job $job)
    {
        $this->authorize('update', $job);
        
        $validated = $request->validate([
            'title' => 'required|string|max:100',
            'description' => 'required|string|max:1000',
            'type' => 'required|string|in:full-time,part-time,internship',
            'location' => 'required|string|max:255',
            'salary' => 'nullable|string|max:255',
            'working_hours' => 'required_if:type,part-time,internship|nullable|string|max:255',
            'required_skills' => 'required|string',
            'requirements' => 'required|string|max:1000',
            'duration' => 'required_if:type,internship|nullable|string|in:1_month,3_months,6_months,custom',
            'academic_credit' => 'required_if:type,internship|nullable|boolean',
            'start_date' => 'nullable|date',
            'deadline' => 'nullable|date',
            'benefits' => 'nullable|string|max:500',
            // 'status' => 'required|in:active,closed',  // Comment out or remove this line
        ]);

        // تعيين الحالة كـ "active" إذا لم يتم تقديمها
        $validated['status'] = $request->input('status', 'active');

        // Convert required_skills string to array
        $validated['required_skills'] = array_map('trim', explode(',', $validated['required_skills']));

        $job->update($validated);

        return redirect()->route('company.jobs.index')
            ->with('success', 'Job updated successfully!');
    }

    /**
     * Remove the specified job from storage.
     *
     * @param  \App\Models\Job  $job
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Job $job)
    {
        $this->authorize('delete', $job);
        
        $job->delete();

        return redirect()->route('company.jobs.index')
            ->with('success', 'Job deleted successfully!');
    }
}
