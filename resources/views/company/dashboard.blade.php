<x-layouts.company>
    <div class="space-y-6 lg:space-y-8">
        {{-- Status Alert --}}
        @if(Auth::user()->company->status === 'pending')
            <div class="bg-yellow-100 dark:bg-yellow-900/30 border-l-4 border-yellow-500 text-yellow-700 dark:text-yellow-300 p-4 rounded-md shadow" role="alert">
                <div class="flex">
                    <div class="py-1"><svg class="fill-current h-6 w-6 text-yellow-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/></svg></div>
                    <div>
                        <p class="font-bold">Waiting for Admin Approval</p>
                        <p class="text-sm">Your company profile is under review. We'll notify you upon approval.</p>
                    </div>
                </div>
            </div>
        @elseif(Auth::user()->company->status === 'rejected')
            <div class="bg-red-100 dark:bg-red-900/30 border-l-4 border-red-500 text-red-700 dark:text-red-300 p-4 rounded-md shadow" role="alert">
                 <div class="flex">
                    <div class="py-1"><svg class="fill-current h-6 w-6 text-red-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"/></svg></div>
                    <div>
                        <p class="font-bold">Account Rejected</p>
                        <p class="text-sm">Reason: {{ Auth::user()->company->rejection_reason ?: 'Please contact support.' }}</p>
                    </div>
                </div>
            </div>
        @endif

        {{-- Neumorphic Stats Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
             <x-company.neumorphic-card title="Posted Jobs" value="{{ $postedJobsCount ?? 0 }}" icon="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
             <x-company.neumorphic-card title="Applications Received" value="{{ $applicationsReceivedCount ?? 0 }}" icon="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
             <x-company.neumorphic-card title="Profile Completion" value="{{ $profileCompletionPercentage ?? 0 }}%" icon="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </div>

        {{-- Company Summary & Recent Jobs - Side by Side on large screens --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8">
            <div class="lg:col-span-2">
                <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl p-6 border border-gray-200 dark:border-gray-700 h-full">
                    <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-4">Company Summary</h2>
                     <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-6">
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Company Name</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ Auth::user()->company->company_name }}</dd>
                        </div>
                         <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Field of Work</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ Auth::user()->company->field_of_work }}</dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Status</dt>
                            <dd class="mt-1 text-sm">
                                 <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    {{ Auth::user()->company->status === 'approved' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' :
                                       (Auth::user()->company->status === 'pending' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300' :
                                       'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300') }}">
                                    {{ ucfirst(Auth::user()->company->status) }}
                                </span>
                            </dd>
                        </div>
                    </dl>
                     <div class="mt-6 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <a href="{{ route('company.profile.edit') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-gradient-to-r from-brand-primary to-brand-secondary hover:from-brand-secondary hover:to-brand-primary focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-primary transition-all duration-300">
                            Edit Company Profile
                             <svg class="ml-2 -mr-0.5 h-4 w-4" fill="currentColor" viewBox="0 0 20 20"><path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path></svg>
                        </a>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-1">
                 {{-- Recent Job Postings (Example) --}}
                <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl p-6 border border-gray-200 dark:border-gray-700 h-full">
                    <div class="flex justify-between items-center mb-4">
                         <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Recent Jobs</h2>
                         <a href="{{ route('company.jobs.index') }}" class="text-sm font-medium text-brand-primary hover:text-brand-secondary dark:text-indigo-400 dark:hover:text-indigo-300">
                            View All
                        </a>
                    </div>
                    <div class="space-y-4">
                        @forelse($recentJobs ?? [] as $job)
                             <x-company.job-card :job="$job" class="border dark:border-gray-700 shadow-sm hover:shadow-md"/>
                         @empty
                            <p class="text-center text-gray-500 dark:text-gray-400 py-4">You haven't posted any jobs yet.</p>
                            <div class="text-center">
                                 <a href="{{ route('company.jobs.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-gradient-to-r from-green-500 to-teal-500 hover:from-green-600 hover:to-teal-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-300">
                                    Post a New Job
                                    <svg class="ml-2 -mr-0.5 h-4 w-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
                                </a>
                            </div>
                         @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.company>