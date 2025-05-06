<x-layouts.company>
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl p-6 md:p-8 border border-gray-200 dark:border-gray-700">
        <div class="flex justify-between items-start">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $job->title }}</h1>
                <div class="mt-2 flex items-center text-sm text-gray-500 dark:text-gray-400">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $job->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ ucfirst($job->status) }}
                    </span>
                    <span class="mx-2">•</span>
                    <span>{{ ucfirst($job->type) }}</span>
                    <span class="mx-2">•</span>
                    <span>{{ $job->location ?? 'Remote' }}</span>
                </div>
            </div>
            
            <div class="flex space-x-3">
                <a href="{{ route('company.jobs.edit', $job) }}" class="inline-flex items-center px-3 py-1.5 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <svg class="-ml-1 mr-1 h-4 w-4 text-gray-500 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit
                </a>
                
                <form method="POST" action="{{ route('company.jobs.destroy', $job) }}" onsubmit="return confirm('Are you sure you want to delete this job posting?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center px-3 py-1.5 border border-red-300 dark:border-red-700 rounded-md shadow-sm text-sm font-medium text-red-700 dark:text-red-400 bg-white dark:bg-gray-700 hover:bg-red-50 dark:hover:bg-red-900/20 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        <svg class="-ml-1 mr-1 h-4 w-4 text-red-500 dark:text-red-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Delete
                    </button>
                </form>
            </div>
        </div>
        
        <div class="mt-6 grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 space-y-6">
                <div>
                    <h2 class="text-lg font-medium text-gray-900 dark:text-white">Job Description</h2>
                    <div class="mt-2 prose prose-sm dark:prose-invert max-w-none">
                        {{ $job->description }}
                    </div>
                </div>
                
                <div>
                    <h2 class="text-lg font-medium text-gray-900 dark:text-white">Requirements</h2>
                    <div class="mt-2 prose prose-sm dark:prose-invert max-w-none">
                        {{ $job->requirements }}
                    </div>
                </div>
                
                <div>
                    <h2 class="text-lg font-medium text-gray-900 dark:text-white">Required Skills</h2>
                    <div class="mt-2 flex flex-wrap gap-2">
                        @if(!empty($job->required_skills) && is_array($job->required_skills))
                            @foreach($job->required_skills as $skill)
                                <span class="inline-block bg-gradient-to-r from-indigo-100 to-blue-100 text-indigo-800 dark:from-indigo-900 dark:to-blue-900 dark:text-indigo-300 text-sm font-medium px-3 py-1.5 rounded-full shadow-sm hover:shadow-md transition-all duration-200">
                                    {{ $skill }}
                                </span>
                            @endforeach
                        @else
                            <span class="text-sm text-gray-500 dark:text-gray-400 italic">No specific skills listed</span>
                        @endif
                    </div>
                </div>
                
                @if($job->benefits)
                <div>
                    <h2 class="text-lg font-medium text-gray-900 dark:text-white">Benefits</h2>
                    <div class="mt-2 prose prose-sm dark:prose-invert max-w-none">
                        {{ $job->benefits }}
                    </div>
                </div>
                @endif
            </div>
            
            <div class="space-y-6">
                <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg">
                    <h3 class="text-sm font-medium text-gray-900 dark:text-white">Job Details</h3>
                    <dl class="mt-2 space-y-3">
                        <div class="flex justify-between">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Posted</dt>
                            <dd class="text-sm text-gray-900 dark:text-white">{{ $job->created_at->diffForHumans() }}</dd>
                        </div>
                        
                        <div class="flex justify-between">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Job Type</dt>
                            <dd class="text-sm text-gray-900 dark:text-white">{{ ucfirst($job->type) }}</dd>
                        </div>
                        
                        <div class="flex justify-between">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Location</dt>
                            <dd class="text-sm text-gray-900 dark:text-white">{{ $job->location ?? 'Remote' }}</dd>
                        </div>
                        
                        @if($job->salary_min || $job->salary_max)
                        <div class="flex justify-between">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Salary Range</dt>
                            <dd class="text-sm text-gray-900 dark:text-white">
                                @if($job->salary_min && $job->salary_max)
                                    ${{ number_format($job->salary_min) }} - ${{ number_format($job->salary_max) }}
                                @elseif($job->salary_min)
                                    From ${{ number_format($job->salary_min) }}
                                @elseif($job->salary_max)
                                    Up to ${{ number_format($job->salary_max) }}
                                @endif
                            </dd>
                        </div>
                        @endif
                        
                        <div class="flex justify-between">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Deadline</dt>
                            <dd class="text-sm text-gray-900 dark:text-white">{{ $job->deadline->format('M d, Y') }}</dd>
                        </div>
                    </dl>
                </div>
                
                <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg">
                    <h3 class="text-sm font-medium text-gray-900 dark:text-white">Applications</h3>
                    <div class="mt-2">
                        <p class="text-sm text-gray-500 dark:text-gray-400">Total applications: <span class="font-medium text-gray-900 dark:text-white">{{ $job->applications->count() }}</span></p>
                        <a href="{{ route('company.applications.index', ['job_id' => $job->id]) }}" class="mt-2 inline-flex items-center text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-500">
                            View all applications
                            <svg class="ml-1 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.company>
