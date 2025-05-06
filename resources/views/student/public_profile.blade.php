@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-10">
    <div class="bg-white shadow-lg rounded-xl p-8 border border-gray-200">
        <div class="flex flex-col md:flex-row md:items-center md:space-x-8">
            <div class="flex-shrink-0 flex justify-center md:block mb-6 md:mb-0">
                <img src="{{ $user->profile_photo_path ? asset('storage/' . $user->profile_photo_path) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&color=7F9CF5&background=EBF4FF' }}" alt="Profile Photo" class="w-32 h-32 rounded-full object-cover border-4 border-indigo-100 shadow">
            </div>
            <div class="flex-1">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $user->name }}</h1>
                <p class="text-gray-600 mb-4">{{ $user->email }}</p>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-700 mb-4">
                    <div><span class="font-medium">University:</span> {{ $profile?->university ?? '-' }}</div>
                    <div><span class="font-medium">Major:</span> {{ $profile?->major ?? '-' }}</div>
                    <div><span class="font-medium">Academic Year:</span> {{ $profile?->academic_year ?? '-' }}</div>
                    <div><span class="font-medium">Profile Created At:</span> {{ $profile?->created_at ? $profile->created_at->format('Y-m-d H:i') : '-' }}</div>
                    <div><span class="font-medium">Last Updated:</span> {{ $profile?->updated_at ? $profile->updated_at->format('Y-m-d H:i') : '-' }}</div>
                </div>
                <div class="mt-4">
                    <h2 class="text-lg font-semibold text-gray-800 mb-2">Skills</h2>
                    <p class="text-gray-700">{{ $profile?->skills ?? 'No skills listed.' }}</p>
                </div>
                <div class="mt-4">
                    <h2 class="text-lg font-semibold text-gray-800 mb-2">Interests</h2>
                    <p class="text-gray-700">{{ $profile?->interests ?? 'No interests listed.' }}</p>
                </div>
                @if($profile?->resume_path)
                <div class="mt-4">
                    <a href="{{ asset('storage/'.$profile->resume_path) }}" target="_blank" class="text-indigo-600 hover:underline">View CV</a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 