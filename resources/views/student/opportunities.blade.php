@extends('layouts.student')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white shadow-md rounded-lg border border-gray-100 overflow-hidden">
        <div class="px-6 py-5">
            <h2 class="text-xl font-bold text-gray-800">Browse Opportunities</h2>
            <p class="mt-1 text-sm text-gray-500">Find internships, part-time and full-time positions that match your skills and interests.</p>
        </div>
    </div>
    
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        <!-- Filters Sidebar -->
        <div class="lg:col-span-1">
            <div class="bg-white shadow-md rounded-lg border border-gray-100 overflow-hidden">
                <div class="px-4 py-5 border-b border-gray-100">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-medium text-gray-800">Filters</h3>
                        <button type="button" id="clear-filters" class="text-sm text-indigo-600 hover:text-indigo-800">Clear All</button>
                    </div>
                </div>
                
                <div class="p-4">
                    <form id="filter-form" action="{{ route('student.opportunities') }}" method="GET">
                        <!-- Opportunity Type Filter -->
                        <div class="mb-6">
                            <h4 class="font-medium text-gray-700 mb-3">Opportunity Type</h4>
                            <div class="space-y-2">
                                <div class="flex items-center">
                                    <input id="type-all" name="type[]" value="" type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded" 
                                        {{ !request()->has('type') || in_array('', request('type', [])) ? 'checked' : '' }}>
                                    <label for="type-all" class="ml-3 text-sm text-gray-600">All Types</label>
                                </div>
                                <div class="flex items-center">
                                    <input id="type-full-time" name="type[]" value="full-time" type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                                        {{ in_array('full-time', request('type', [])) ? 'checked' : '' }}>
                                    <label for="type-full-time" class="ml-3 text-sm text-gray-600">Full-Time</label>
                                </div>
                                <div class="flex items-center">
                                    <input id="type-part-time" name="type[]" value="part-time" type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                                        {{ in_array('part-time', request('type', [])) ? 'checked' : '' }}>
                                    <label for="type-part-time" class="ml-3 text-sm text-gray-600">Part-Time</label>
                                </div>
                                <div class="flex items-center">
                                    <input id="type-internship" name="type[]" value="internship" type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                                        {{ in_array('internship', request('type', [])) ? 'checked' : '' }}>
                                    <label for="type-internship" class="ml-3 text-sm text-gray-600">Internship</label>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Field/Industry Filter -->
                        <div class="mb-6">
                            <h4 class="font-medium text-gray-700 mb-3">Field / Industry</h4>
                            <select name="field" class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                <option value="">All Fields</option>
                                <option value="technology" {{ request('field') == 'technology' ? 'selected' : '' }}>Technology</option>
                                <option value="business" {{ request('field') == 'business' ? 'selected' : '' }}>Business & Finance</option>
                                <option value="healthcare" {{ request('field') == 'healthcare' ? 'selected' : '' }}>Healthcare</option>
                                <option value="engineering" {{ request('field') == 'engineering' ? 'selected' : '' }}>Engineering</option>
                                <option value="education" {{ request('field') == 'education' ? 'selected' : '' }}>Education</option>
                                <option value="arts" {{ request('field') == 'arts' ? 'selected' : '' }}>Arts & Design</option>
                                <option value="marketing" {{ request('field') == 'marketing' ? 'selected' : '' }}>Marketing & Communications</option>
                                <option value="science" {{ request('field') == 'science' ? 'selected' : '' }}>Science & Research</option>
                            </select>
                        </div>
                        
                        <!-- Location Filter -->
                        <div class="mb-6">
                            <h4 class="font-medium text-gray-700 mb-3">Location</h4>
                            <div class="space-y-2">
                                <div class="flex items-center">
                                    <input id="location-all" name="location[]" value="" type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                                        {{ !request()->has('location') || in_array('', request('location', [])) ? 'checked' : '' }}>
                                    <label for="location-all" class="ml-3 text-sm text-gray-600">All Locations</label>
                                </div>
                                <div class="flex items-center">
                                    <input id="location-remote" name="location[]" value="remote" type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                                        {{ in_array('remote', request('location', [])) ? 'checked' : '' }}>
                                    <label for="location-remote" class="ml-3 text-sm text-gray-600">Remote</label>
                                </div>
                                <div class="flex items-center">
                                    <input id="location-onsite" name="location[]" value="onsite" type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                                        {{ in_array('onsite', request('location', [])) ? 'checked' : '' }}>
                                    <label for="location-onsite" class="ml-3 text-sm text-gray-600">On-site</label>
                                </div>
                                <div class="flex items-center">
                                    <input id="location-hybrid" name="location[]" value="hybrid" type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                                        {{ in_array('hybrid', request('location', [])) ? 'checked' : '' }}>
                                    <label for="location-hybrid" class="ml-3 text-sm text-gray-600">Hybrid</label>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Skills Filter -->
                        <div class="mb-6">
                            <h4 class="font-medium text-gray-700 mb-3">Required Skills</h4>
                            <div class="space-y-2">
                                @php
                                    $commonSkills = ['JavaScript', 'Python', 'Java', 'React', 'Angular', 'SQL', 'Communication', 'Project Management'];
                                @endphp
                                
                                @foreach($commonSkills as $skill)
                                    <div class="flex items-center">
                                        <input id="skill-{{ Str::slug($skill) }}" name="skills[]" value="{{ $skill }}" type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                                            {{ in_array($skill, request('skills', [])) ? 'checked' : '' }}>
                                        <label for="skill-{{ Str::slug($skill) }}" class="ml-3 text-sm text-gray-600">{{ $skill }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        
                        <!-- Search Button -->
                        <div>
                            <button type="submit" class="w-full inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Apply Filters
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Opportunities List -->
        <div class="lg:col-span-3">
            <!-- Search Bar -->
            <div class="bg-white shadow-md rounded-lg border border-gray-100 overflow-hidden mb-6">
                <div class="p-4">
                    <form class="flex" action="{{ route('student.opportunities') }}" method="GET" id="search-form">
                        <div class="flex-1 mr-2">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by job title, company, or keyword" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                        </div>
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            Search
                        </button>
                    </form>
                </div>
            </div>
            
            <!-- Results -->
            <div class="bg-white shadow-md rounded-lg border border-gray-100 overflow-hidden">
                <div class="divide-y divide-gray-100">
                    @php
                        // In a real application, this would come from the controller
                        // Here we're simulating the result of a filtered query
                        $opportunities = \App\Models\Job::where('status', 'active')
                            ->when(request('search'), function($query, $search) {
                                return $query->where('title', 'like', "%{$search}%")
                                    ->orWhere('description', 'like', "%{$search}%");
                            })
                            ->when(request('type') && !in_array('', request('type')), function($query) {
                                return $query->whereIn('type', request('type'));
                            })
                            ->latest()
                            ->paginate(10);
                    @endphp
                    
                    @if($opportunities->count() > 0)
                        @foreach($opportunities as $opportunity)
                            <div class="p-6 hover:bg-gray-50 transition-colors duration-150">
                                <div class="flex items-start">
                                    @if($opportunity->company && $opportunity->company->logo_path)
                                        <img src="{{ Storage::url($opportunity->company->logo_path) }}" alt="{{ $opportunity->company->name }}" class="w-16 h-16 rounded-lg object-cover mr-4">
                                    @else
                                        <div class="w-16 h-16 rounded-lg bg-gray-200 flex items-center justify-center mr-4">
                                            <svg class="w-8 h-8 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                            </svg>
                                        </div>
                                    @endif
                                    
                                    <div class="flex-1">
                                        <div class="flex items-center justify-between">
                                            <h3 class="text-lg font-medium text-gray-800">{{ $opportunity->title }}</h3>
                                            <span class="inline-flex items-center rounded-full bg-indigo-50 px-2.5 py-0.5 text-xs font-medium text-indigo-600">
                                                {{ ucfirst($opportunity->type) }}
                                            </span>
                                        </div>
                                        
                                        <p class="text-sm text-gray-600">{{ $opportunity->company->name ?? 'Company' }}</p>
                                        
                                        <div class="mt-2 flex items-center text-sm text-gray-500">
                                            <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                            {{ $opportunity->location }}
                                        </div>
                                        
                                        <div class="mt-2 flex items-center text-sm text-gray-500">
                                            @if($opportunity->salary)
                                                <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                {{ $opportunity->salary }}
                                            @endif
                                        </div>
                                        
                                        <div class="mt-3 flex flex-wrap items-center gap-2">
                                            @foreach(array_slice(is_array($opportunity->required_skills) ? $opportunity->required_skills : (json_decode($opportunity->required_skills, true) ?? []), 0, 3) as $skill)
                                                <span class="inline-flex items-center rounded-full bg-gray-50 px-2 py-1 text-xs font-medium text-gray-600">
                                                    {{ $skill }}
                                                </span>
                                            @endforeach
                                        </div>
                                        
                                        <div class="mt-4 flex">
                                            <a href="{{ route('student.opportunities.show', $opportunity->id) }}" class="inline-flex items-center px-3 py-1.5 border border-indigo-600 text-xs font-medium rounded-lg text-indigo-600 bg-white hover:bg-indigo-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-150">
                                                View Details
                                                <svg class="ml-1.5 -mr-0.5 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                                </svg>
                                            </a>
                                            <a href="{{ route('student.opportunities.apply', $opportunity->id) }}" class="ml-3 inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-150">
                                                Apply Now
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        
                        <!-- Pagination -->
                        <div class="px-6 py-4 bg-gray-50">
                            {{ $opportunities->appends(request()->query())->links() }}
                        </div>
                    @else
                        <div class="p-6 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No opportunities found</h3>
                            <p class="mt-1 text-sm text-gray-500">Try changing your search or filter criteria.</p>
                            <div class="mt-6">
                                <button type="button" id="reset-search" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-indigo-600 bg-indigo-100 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Reset Filters
                                </button>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle clear all filters
        document.getElementById('clear-filters').addEventListener('click', function() {
            const form = document.getElementById('filter-form');
            const inputs = form.querySelectorAll('input[type="checkbox"], select');
            
            inputs.forEach(input => {
                if (input.type === 'checkbox') {
                    input.checked = input.id.endsWith('-all');
                } else if (input.tagName === 'SELECT') {
                    input.selectedIndex = 0;
                }
            });
            
            form.submit();
        });
        
        // Handle reset search
        document.getElementById('reset-search').addEventListener('click', function() {
            window.location.href = "{{ route('student.opportunities') }}";
        });
        
        // Handle "All Types" checkbox logic
        document.getElementById('type-all').addEventListener('change', function() {
            if (this.checked) {
                document.getElementById('type-full-time').checked = false;
                document.getElementById('type-part-time').checked = false;
                document.getElementById('type-internship').checked = false;
            }
        });
        
        const typeCheckboxes = ['type-full-time', 'type-part-time', 'type-internship'];
        typeCheckboxes.forEach(id => {
            document.getElementById(id).addEventListener('change', function() {
                if (this.checked) {
                    document.getElementById('type-all').checked = false;
                }
                
                // If no specific type is checked, check "All Types"
                if (!typeCheckboxes.some(typeId => document.getElementById(typeId).checked)) {
                    document.getElementById('type-all').checked = true;
                }
            });
        });
        
        // Handle "All Locations" checkbox logic
        document.getElementById('location-all').addEventListener('change', function() {
            if (this.checked) {
                document.getElementById('location-remote').checked = false;
                document.getElementById('location-onsite').checked = false;
                document.getElementById('location-hybrid').checked = false;
            }
        });
        
        const locationCheckboxes = ['location-remote', 'location-onsite', 'location-hybrid'];
        locationCheckboxes.forEach(id => {
            document.getElementById(id).addEventListener('change', function() {
                if (this.checked) {
                    document.getElementById('location-all').checked = false;
                }
                
                // If no specific location is checked, check "All Locations"
                if (!locationCheckboxes.some(locId => document.getElementById(locId).checked)) {
                    document.getElementById('location-all').checked = true;
                }
            });
        });
    });
</script>
@endpush
@endsection 