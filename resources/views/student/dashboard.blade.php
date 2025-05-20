@php $hideSidebar = true; @endphp
@extends('layouts.student')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="space-y-6">
        <!-- Welcome Banner -->
        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-lg shadow-lg">
            <div class="px-6 py-8 md:px-10">
                <h1 class="text-2xl md:text-3xl font-bold text-white">Welcome, {{ Auth::user()->name }}!</h1>
                @php $isJobSeeker = Auth::user() && Auth::user()->isJobSeeker(); @endphp
                <p class="mt-2 text-indigo-100">
                    @if($isJobSeeker)
                        Your gateway to job opportunities that match your profile.
                    @else
                        Your gateway to internships and opportunities that match your profile.
                    @endif
                </p>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Profile Completion Card -->
            <div class="bg-white rounded-lg shadow-md border border-gray-100 overflow-hidden">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-semibold text-gray-800">Profile Completion</h2>
                        <a href="{{ route('student.profile') }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">Complete Profile</a>
                    </div>
                    @php
                        $profile = Auth::user()->studentProfile ?? null;
                        $totalFields = 7;
                        $completedFields = 0;
                        if ($profile) {
                            if ($profile->university) $completedFields++;
                            if ($profile->major) $completedFields++;
                            if ($profile->academic_year) $completedFields++;
                            if ($profile->skills) $completedFields++;
                            if ($profile->interests) $completedFields++;
                            if ($profile->resume_path) $completedFields++;
                        }
                        if (Auth::user()->name && Auth::user()->email) $completedFields++;
                        $completionPercentage = round(($completedFields / $totalFields) * 100);
                    @endphp
                    <div class="relative pt-1">
                        <div class="flex mb-2 items-center justify-between">
                            <div>
                                <span class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full text-indigo-600 bg-indigo-100">
                                    Progress
                                </span>
                            </div>
                            <div class="text-right">
                                <span class="text-xs font-semibold inline-block text-indigo-600">
                                    {{ $completionPercentage }}%
                                </span>
                            </div>
                        </div>
                        <div class="flex h-2 mb-4 overflow-hidden rounded bg-indigo-100">
                            <div style="width: {{ $completionPercentage }}%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-gradient-to-r from-indigo-500 to-purple-500 transition-all duration-500"></div>
                        </div>
                    </div>
                    @if($completionPercentage < 100)
                        <p class="text-sm text-gray-600">Complete your profile to increase your chances of finding the perfect opportunity.</p>
                    @else
                        <p class="text-sm text-gray-600">Great job! Your profile is complete and ready for opportunities.</p>
                    @endif
                </div>
            </div>
            <!-- New Notifications Card -->
            <div class="bg-white rounded-lg shadow-md border border-gray-100 overflow-hidden">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-semibold text-gray-800">New Notifications</h2>
                        <a href="{{ route('student.notifications') }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">View All</a>
                    </div>
                    <div class="space-y-4">
                        @forelse(Auth::user()->notifications()->latest()->take(3)->get() as $notification)
                            <div class="border-l-4 {{ $notification->read_at ? 'border-gray-300' : 'border-indigo-500' }} pl-4 py-2">
                                <p class="text-sm text-gray-800">{{ $notification->data['message'] ?? 'Notification' }}</p>
                                <p class="text-xs text-gray-500 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                            </div>
                        @empty
                            <div class="text-center py-4">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                                </svg>
                                <p class="mt-2 text-sm text-gray-600">No new notifications</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
            <!-- Quick Actions Card -->
            <div class="bg-white rounded-lg shadow-md border border-gray-100 overflow-hidden">
                <div class="p-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Quick Actions</h2>
                    <div class="space-y-3">
                        <a href="{{ route('student.opportunities') }}" class="flex items-center p-3 bg-gray-50 hover:bg-indigo-50 rounded-lg transition-colors duration-200">
                            <div class="rounded-full bg-indigo-100 p-2 mr-3">
                                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-sm font-medium text-gray-800">Browse Opportunities</h3>
                                <p class="text-xs text-gray-500">
                                    @if($isJobSeeker)
                                        Find job openings
                                    @else
                                        Find internships and job openings
                                    @endif
                                </p>
                            </div>
                        </a>
                        <a href="{{ route('student.profile') }}" class="flex items-center p-3 bg-gray-50 hover:bg-indigo-50 rounded-lg transition-colors duration-200">
                            <div class="rounded-full bg-indigo-100 p-2 mr-3">
                                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-sm font-medium text-gray-800">Update Profile</h3>
                                <p class="text-xs text-gray-500">Edit your information and skills</p>
                            </div>
                        </a>
                        <a href="{{ route('student.messages') }}" class="flex items-center p-3 bg-gray-50 hover:bg-indigo-50 rounded-lg transition-colors duration-200">
                            <div class="rounded-full bg-indigo-100 p-2 mr-3">
                                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-sm font-medium text-gray-800">Check Messages</h3>
                                <p class="text-xs text-gray-500">View conversations with companies</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Recommended Opportunities -->
        <div class="bg-white rounded-lg shadow-md border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-gray-800">New Opportunities</h2>
                    <a href="{{ route('student.opportunities') }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">View All</a>
                </div>
            </div>
            <div class="divide-y divide-gray-100">
                @php
                    $recommendedOpportunities = \App\Models\Job::where('status', 'active')->latest()->take(3)->get();
                @endphp
                @forelse($recommendedOpportunities as $opportunity)
                    <div class="p-6 hover:bg-gray-50 transition-colors duration-150">
                        <div class="flex items-start">
                            @if($opportunity->company && $opportunity->company->logo_path)
                                <img src="{{ Storage::url($opportunity->company->logo_path) }}" alt="{{ $opportunity->company->name }}" class="w-12 h-12 rounded-lg object-cover mr-4">
                            @else
                                <div class="w-12 h-12 rounded-lg bg-gray-200 flex items-center justify-center mr-4">
                                    <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                </div>
                            @endif
                            <div class="flex-1">
                                <h3 class="text-base font-medium text-gray-800">{{ $opportunity->title }}</h3>
                                <p class="text-sm text-gray-600">{{ $opportunity->company->name ?? 'Company' }}</p>
                                <div class="mt-2 flex items-center text-sm text-gray-500">
                                    <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    {{ $opportunity->location }}
                                </div>
                                <div class="mt-3 flex flex-wrap items-center gap-2">
                                    <span class="inline-flex items-center rounded-full bg-indigo-50 px-2 py-1 text-xs font-medium text-indigo-600">
                                        {{ ucfirst($opportunity->type) }}
                                    </span>
                                    @if($opportunity->salary)
                                        <span class="inline-flex items-center rounded-full bg-green-50 px-2 py-1 text-xs font-medium text-green-600">
                                            {{ $opportunity->salary }}
                                        </span>
                                    @endif
                                    @foreach(array_slice(is_array($opportunity->required_skills) ? $opportunity->required_skills : (json_decode($opportunity->required_skills, true) ?? []), 0, 2) as $skill)
                                        <span class="inline-flex items-center rounded-full bg-gray-50 px-2 py-1 text-xs font-medium text-gray-600">
                                            {{ $skill }}
                                        </span>
                                    @endforeach
                                </div>
                                <div class="mt-4">
                                    <a href="{{ route('student.opportunities.show', $opportunity->id) }}" class="inline-flex items-center px-3 py-1.5 border border-indigo-600 text-xs font-medium rounded-lg text-indigo-600 bg-white hover:bg-indigo-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-150">
                                        View Details
                                        <svg class="ml-1.5 -mr-0.5 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-6 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No opportunities found</h3>
                        <p class="mt-1 text-sm text-gray-500">Complete your profile to get personalized recommendations.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection 