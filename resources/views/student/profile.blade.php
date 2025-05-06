@extends('layouts.student')

@section('content')
<div class="max-w-3xl mx-auto p-6 bg-white rounded-lg shadow mt-8">
    <h2 class="text-2xl font-bold mb-6 text-center">Student Profile</h2>
    <div class="flex flex-col items-center mb-6">
        <img src="{{ auth()->user()->profile_photo_path ? asset('storage/' . auth()->user()->profile_photo_path) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&color=7F9CF5&background=EBF4FF' }}" class="h-24 w-24 rounded-full object-cover border-4 border-indigo-200 shadow mb-2" alt="Profile Photo">
        <span class="text-lg font-semibold text-gray-700">{{ auth()->user()->name }}</span>
    </div>
    <form action="{{ route('student.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')
        <!-- Profile Photo Upload -->
        <div>
            <label class="block text-sm font-medium mb-1">Profile Photo</label>
            <input type="file" name="profile_photo" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" />
            <p class="text-xs text-gray-400 mt-1">Upload a profile photo (JPG, PNG, etc.).</p>
        </div>
        <!-- Personal Information -->
        <div class="bg-gray-50 p-4 rounded-lg border">
            <h3 class="text-lg font-semibold mb-2 text-indigo-700">Personal Information</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Full Name</label>
                    <input type="text" name="name" class="w-full border rounded px-3 py-2" value="{{ old('name', auth()->user()->name) }}" required>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Email</label>
                    <input type="email" name="email" class="w-full border rounded px-3 py-2" value="{{ old('email', auth()->user()->email) }}" required>
                </div>
            </div>
        </div>
        <!-- Academic Information -->
        <div class="bg-gray-50 p-4 rounded-lg border">
            <h3 class="text-lg font-semibold mb-2 text-indigo-700">Academic Information</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">University</label>
                    <input type="text" name="university" class="w-full border rounded px-3 py-2" value="{{ old('university', $profile?->university) }}" required>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Major</label>
                    <input type="text" name="major" class="w-full border rounded px-3 py-2" value="{{ old('major', $profile?->major) }}" required>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Academic Year</label>
                    <input type="text" name="academic_year" class="w-full border rounded px-3 py-2" value="{{ old('academic_year', $profile?->academic_year) }}" required>
                </div>
            </div>
        </div>
        <!-- Skills & Interests -->
        <div class="bg-gray-50 p-4 rounded-lg border">
            <h3 class="text-lg font-semibold mb-2 text-indigo-700">Skills & Interests</h3>
            <div class="mb-2">
                <label class="block text-sm font-medium mb-1">Skills (Technical, Personal, Languages)</label>
                <input type="text" name="skills" class="w-full border rounded px-3 py-2" placeholder="e.g. Python, Teamwork, English (Advanced)" value="{{ old('skills', $profile?->skills) }}">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Interests</label>
                <input type="text" name="interests" class="w-full border rounded px-3 py-2" placeholder="e.g. AI, Design, Volunteering" value="{{ old('interests', $profile?->interests) }}">
            </div>
        </div>
        <!-- Resume Upload -->
        <div class="bg-gray-50 p-4 rounded-lg border">
            <h3 class="text-lg font-semibold mb-2 text-indigo-700">Resume (CV)</h3>
            <input type="file" name="resume" accept=".pdf" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
            @if($profile?->resume_path)
                <p class="text-xs text-green-600 mt-1">Current CV: <a href="{{ asset('storage/'.$profile->resume_path) }}" target="_blank" class="underline">View</a></p>
            @endif
            <p class="text-xs text-gray-400 mt-1">Upload your CV as a PDF file.</p>
        </div>
        <div class="text-center">
            <button type="submit" class="bg-indigo-600 text-white px-8 py-2 rounded-lg shadow hover:bg-indigo-700 transition">Save Profile</button>
        </div>
    </form>
</div>
@endsection 