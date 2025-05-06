<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\JobSeekerProfile;
use App\Models\StudentProfile;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'string', 'in:student,company,job_seeker'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        // Create profile based on role
        switch ($request->role) {
            case 'student':
                $this->createStudentProfile($user, $request);
                break;
            case 'company':
                $this->createCompanyProfile($user, $request);
                break;
            case 'job_seeker':
                $this->createJobSeekerProfile($user, $request);
                break;
        }

        event(new Registered($user));

        Auth::login($user);

        // Redirect based on role
        switch ($user->role) {
            case 'student':
                return redirect()->route('student.dashboard');
            case 'company':
                return redirect()->route('company.dashboard');
            case 'job_seeker':
                return redirect()->route('job_seeker.dashboard');
            default:
                return redirect()->route('dashboard');
        }
    }

    protected function createStudentProfile(User $user, Request $request)
    {
        $request->validate([
            'university' => ['required', 'string', 'max:255'],
            'major' => ['required', 'string', 'max:255'],
            'academic_year' => ['required', 'string', 'max:255'],
        ]);

        StudentProfile::create([
            'user_id' => $user->id,
            'university' => $request->university,
            'major' => $request->major,
            'academic_year' => $request->academic_year,
        ]);
    }

    protected function createCompanyProfile(User $user, Request $request)
    {
        $request->validate([
            'company_name' => ['required', 'string', 'max:255'],
            'field_of_work' => ['required', 'string', 'max:255'],
            'company_size' => ['required', 'string', 'max:255'],
            'location' => ['required', 'string', 'max:255'],
            'company_email' => ['required', 'string', 'email', 'max:255', 'unique:companies'],
            'description' => ['required', 'string'],
            'document' => ['required', 'file', 'mimes:pdf,jpg,png', 'max:2048'],
        ]);

        $documentPath = $request->file('document')->store('company_documents', 'public');

        Company::create([
            'user_id' => $user->id,
            'company_name' => $request->company_name,
            'field_of_work' => $request->field_of_work,
            'company_size' => $request->company_size,
            'location' => $request->location,
            'company_email' => $request->company_email,
            'description' => $request->description,
            'document_path' => $documentPath,
            'status' => 'pending',
        ]);
    }

    protected function createJobSeekerProfile(User $user, Request $request)
    {
        JobSeekerProfile::create([
            'user_id' => $user->id,
        ]);
    }
} 