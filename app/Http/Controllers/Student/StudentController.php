<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\StudentProfile;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    /**
     * Show the student dashboard.
     */
    public function dashboard()
    {
        return view('student.dashboard');
    }

    /**
     * Show the student profile.
     */
    public function profile()
    {
        $user = Auth::user();
        $profile = $user->studentProfile;
        
        return view('student.profile', compact('profile'));
    }

    /**
     * Update the student profile.
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $validatedData = $request->validate([
            'university' => 'required|string|max:255',
            'major' => 'required|string|max:255',
            'academic_year' => 'required|integer|min:1|max:6',
            'skills' => 'nullable|string',
            'interests' => 'nullable|string',
            'resume' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120', // 5MB
        ]);
        
        // Create or update student profile
        $profile = StudentProfile::updateOrCreate(
            ['user_id' => $user->id],
            [
                'university' => $validatedData['university'],
                'major' => $validatedData['major'],
                'academic_year' => $validatedData['academic_year'],
                'skills' => $validatedData['skills'],
                'interests' => $validatedData['interests'],
            ]
        );
        
        // Handle resume upload
        if ($request->hasFile('resume')) {
            // Delete old resume if exists
            if ($profile->resume_path) {
                Storage::delete($profile->resume_path);
            }
            
            // Store new resume
            $resumePath = $request->file('resume')->store('resumes/'.Auth::id(), 'public');
            $profile->resume_path = $resumePath;
            $profile->save();
        }

        // Handle profile photo upload
        if ($request->hasFile('profile_photo')) {
            // Delete old photo if exists
            if ($user->profile_photo_path) {
                Storage::disk('public')->delete($user->profile_photo_path);
            }
            $photoPath = $request->file('profile_photo')->store('profile_photos', 'public');
            $user->profile_photo_path = $photoPath;
            $user->save();
        }
        
        return redirect()->route('student.dashboard')->with('success', 'Profile updated successfully!');
    }

    /**
     * Show all opportunities (jobs).
     */
    public function opportunities(Request $request)
    {
        $query = Job::where('status', 'active');
        if (Auth::user()->isJobSeeker()) {
            $query->where('type', '!=', 'internship');
        }
        
        // Apply search filter
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        // Apply type filter
        if ($request->filled('type') && !in_array('', $request->input('type'))) {
            $query->whereIn('type', $request->input('type'));
        }
        
        // Apply field/industry filter
        if ($request->filled('field') && $request->input('field') !== '') {
            // This would need a field column or tag in the opportunities table
            // For now, we'll search in the description
            $query->where('description', 'like', "%{$request->input('field')}%");
        }
        
        // Apply location filter
        if ($request->filled('location') && !in_array('', $request->input('location'))) {
            $query->where(function ($q) use ($request) {
                foreach ($request->input('location') as $location) {
                    $q->orWhere('location', 'like', "%{$location}%");
                }
            });
        }
        
        // Apply skills filter
        if ($request->filled('skills')) {
            $query->where(function ($q) use ($request) {
                foreach ($request->input('skills') as $skill) {
                    // This assumes skills are stored as JSON
                    $q->orWhereJsonContains('required_skills', $skill);
                }
            });
        }
        
        $opportunities = $query->latest()->paginate(10);
        
        return view('student.opportunities', compact('opportunities'));
    }

    /**
     * Show a specific opportunity.
     */
    public function showOpportunity($id)
    {
        $opportunity = Job::findOrFail($id);
        return view('student.opportunities.show', compact('opportunity'));
    }

    /**
     * Apply for an opportunity.
     */
    public function applyOpportunity($id)
    {
        $opportunity = Job::findOrFail($id);
        $hasApplied = $opportunity->applications()->where('user_id', Auth::id())->exists();
        if ($hasApplied) {
            return redirect()->back()->with('error', 'You have already applied for this opportunity.');
        }
        $data = [
            'job_id' => $opportunity->id,
            'user_id' => Auth::id(),
            'company_id' => $opportunity->company_id,
            'status' => 'pending',
            'message' => request('message'),
        ];
        if (request()->hasFile('cv')) {
            $cvPath = request()->file('cv')->store('applications/cv', 'public');
            $data['cv_path'] = $cvPath;
        }
        \App\Models\Application::create($data);
        // إشعار الشركة بوجود طلب جديد
        \App\Models\Notification::create([
            'user_id' => $opportunity->company->user_id,
            'title' => 'New Application',
            'message' => 'A new application has been submitted for your opportunity: "' . $opportunity->title . '"',
            'type' => 'info',
        ]);
        return redirect()->route('student.opportunities')->with('success', 'Application submitted successfully!');
    }

    /**
     * Show student messages.
     */
    public function messages()
    {
        // جلب جميع المستخدمين (شركات أو غيرهم) ما عدا الطالب الحالي
        $users = \App\Models\User::where('id', '!=', auth()->id())->get();
        return view('student.messages', compact('users'));
    }

    /**
     * Show student notifications.
     */
    public function notifications()
    {
        $notifications = auth()->user()->notifications()->orderBy('created_at', 'desc')->get();
        return view('student.notifications', compact('notifications'));
    }

    /**
     * Show the public profile for a student (for companies/guests).
     */
    public function showPublicProfile($id)
    {
        $user = \App\Models\User::findOrFail($id);
        $profile = $user->studentProfile;
        return view('student.public_profile', compact('user', 'profile'));
    }
} 