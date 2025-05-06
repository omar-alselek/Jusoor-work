@extends('layouts.student')

@section('content')
<div class="space-y-6">
    <!-- Back Button -->
    <div>
        <a href="{{ route('student.opportunities') }}" class="inline-flex items-center text-sm font-medium text-indigo-600 hover:text-indigo-900">
            <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Opportunities
        </a>
    </div>
    
    <!-- Opportunity Header -->
    <div class="bg-white shadow-md rounded-lg border border-gray-100 overflow-hidden">
        <div class="p-6">
            <div class="flex flex-col md:flex-row md:items-start">
                @if($opportunity->company && $opportunity->company->logo_path)
                    <img src="{{ Storage::url($opportunity->company->logo_path) }}" alt="{{ $opportunity->company->name }}" class="w-20 h-20 rounded-lg object-cover mr-6 mb-4 md:mb-0">
                @else
                    <div class="w-20 h-20 rounded-lg bg-gray-200 flex items-center justify-center mr-6 mb-4 md:mb-0">
                        <svg class="w-10 h-10 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                @endif
                
                <div class="flex-1">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">{{ $opportunity->title }}</h1>
                            <p class="text-gray-600">{{ $opportunity->company->name ?? 'Company' }}</p>
                        </div>
                        <div class="mt-3 md:mt-0">
                            <span class="inline-flex items-center rounded-full bg-indigo-50 px-2.5 py-0.5 text-xs font-medium text-indigo-600">
                                {{ ucfirst($opportunity->type) }}
                            </span>
                        </div>
                    </div>
                    
                    <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <div class="flex items-center text-sm text-gray-500">
                                <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                {{ $opportunity->location }}
                            </div>
                        </div>
                        
                        <div>
                            @if($opportunity->salary)
                                <div class="flex items-center text-sm text-gray-500">
                                    <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $opportunity->salary }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mt-6 flex flex-wrap gap-2">
                @foreach(is_array($opportunity->required_skills) ? $opportunity->required_skills : (json_decode($opportunity->required_skills, true) ?? []) as $skill)
                    <span class="inline-flex items-center rounded-full bg-gray-100 px-3 py-1 text-sm font-medium text-gray-800">
                        {{ $skill }}
                    </span>
                @endforeach
            </div>
            
            <div class="mt-6 flex flex-col md:flex-row md:items-center md:space-x-4">
                <form action="{{ route('student.opportunities.apply', $opportunity->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4 text-left">
                        <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Message (optional)</label>
                        <textarea name="message" id="message" rows="3" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">{{ old('message') }}</textarea>
                    </div>
                    <div class="mb-4 text-left">
                        <label for="cv" class="block text-sm font-medium text-gray-700 mb-1">Upload CV (PDF, DOC, DOCX, max 10MB, optional)</label>
                        <input type="file" name="cv" id="cv" accept=".pdf,.doc,.docx" class="block w-full text-sm text-gray-700 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <button type="submit" class="inline-flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Apply for This Opportunity
                    </button>
                </form>
                
                <a href="mailto:{{ $opportunity->company->email ?? '' }}" class="mt-3 md:mt-0 w-full md:w-auto inline-flex items-center justify-center px-6 py-3 border border-gray-300 shadow-sm text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Contact Company
                </a>
                
                @if($opportunity->company)
                <a href="{{ route('company.public_profile', $opportunity->company->id) }}" class="mt-3 md:mt-0 w-full md:w-auto inline-flex items-center justify-center px-6 py-3 border border-blue-300 shadow-sm text-base font-medium rounded-md text-blue-700 bg-blue-50 hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    View company profile
                </a>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Opportunity Details -->
    <div class="bg-white shadow-md rounded-lg border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100">
            <h2 class="text-lg font-medium text-gray-800">Job Description</h2>
        </div>
        
        <div class="p-6 prose max-w-none">
            {!! nl2br(e($opportunity->description)) !!}
        </div>
    </div>
    
    <!-- Requirements -->
    <div class="bg-white shadow-md rounded-lg border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100">
            <h2 class="text-lg font-medium text-gray-800">Requirements</h2>
        </div>
        
        <div class="p-6 prose max-w-none">
            {!! nl2br(e($opportunity->requirements)) !!}
        </div>
    </div>
    
    <!-- Additional Info -->
    @if($opportunity->type === 'internship')
        <div class="bg-white shadow-md rounded-lg border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100">
                <h2 class="text-lg font-medium text-gray-800">Internship Details</h2>
            </div>
            
            <div class="p-6">
                <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-6">
                    @if($opportunity->duration)
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Duration</dt>
                            <dd class="mt-1 text-base text-gray-900">{{ str_replace('_', ' ', ucfirst($opportunity->duration)) }}</dd>
                        </div>
                    @endif
                    
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Academic Credit</dt>
                        <dd class="mt-1 text-base text-gray-900">{{ $opportunity->academic_credit ? 'Yes' : 'No' }}</dd>
                    </div>
                </dl>
            </div>
        </div>
    @endif
    
    <!-- Benefits -->
    @if($opportunity->benefits)
        <div class="bg-white shadow-md rounded-lg border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100">
                <h2 class="text-lg font-medium text-gray-800">Benefits</h2>
            </div>
            
            <div class="p-6 prose max-w-none">
                {!! nl2br(e($opportunity->benefits)) !!}
            </div>
        </div>
    @endif
    
    <!-- Important Dates -->
    <div class="bg-white shadow-md rounded-lg border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100">
            <h2 class="text-lg font-medium text-gray-800">Important Dates</h2>
        </div>
        
        <div class="p-6">
            <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-6">
                @if($opportunity->deadline)
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Application Deadline</dt>
                        <dd class="mt-1 text-base text-gray-900">{{ $opportunity->deadline->format('F j, Y') }}</dd>
                    </div>
                @endif
                
                @if($opportunity->start_date)
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Expected Start Date</dt>
                        <dd class="mt-1 text-base text-gray-900">{{ $opportunity->start_date->format('F j, Y') }}</dd>
                    </div>
                @endif
            </dl>
        </div>
    </div>
    
    <!-- Apply Button (Bottom) -->
    <div class="bg-white shadow-md rounded-lg border border-gray-100 overflow-hidden p-6">
        <div class="text-center">
            <h3 class="text-lg font-medium text-gray-900 mb-3">Ready to Apply?</h3>
            <p class="text-gray-600 mb-6">Submit your application now and take the first step towards your new career opportunity!</p>
            
            <form action="{{ route('student.opportunities.apply', $opportunity->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-4 text-left">
                    <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Message (optional)</label>
                    <textarea name="message" id="message" rows="3" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">{{ old('message') }}</textarea>
                </div>
                <div class="mb-4 text-left">
                    <label for="cv" class="block text-sm font-medium text-gray-700 mb-1">Upload CV (PDF, DOC, DOCX, max 10MB, optional)</label>
                    <input type="file" name="cv" id="cv" accept=".pdf,.doc,.docx" class="block w-full text-sm text-gray-700 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <button type="submit" class="inline-flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Apply for This Opportunity
                </button>
            </form>
        </div>
    </div>
</div>
@endsection 