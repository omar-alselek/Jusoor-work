<x-layouts.company>
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl p-6 md:p-8 border border-gray-200 dark:border-gray-700">
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white mb-6">Job Applications</h1>

        {{-- Add Filters (Example: Skills, Experience) - requires backend logic --}}
        <div class="mb-6 grid grid-cols-1 md:grid-cols-3 gap-4">
             <x-form.input name="filter_skill" label="Filter by Skill" placeholder="e.g., PHP" />
             <x-form.input name="filter_experience" type="number" label="Min. Experience (Years)" placeholder="e.g., 2" />
             <button type="button" class="mt-5 h-10 inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-brand-primary hover:bg-brand-secondary focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-primary transition-colors">
                Apply Filters
             </button>
        </div>

         <div class="overflow-x-auto">
             <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                 <thead class="bg-gray-50 dark:bg-gray-700">
                     <tr>
                         <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Applicant</th>
                         <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Job</th>
                         <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date Applied</th>
                         <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                         <th scope="col" class="relative px-6 py-3">
                             <span class="sr-only">Actions</span>
                         </th>
                     </tr>
                 </thead>
                 <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse ($applications as $application)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        {{-- Placeholder Avatar --}}
                                         <img class="h-10 w-10 rounded-full" src="https://ui-avatars.com/api/?name={{ urlencode($application->user->name ?? 'Applicant') }}&color=7F9CF5&background=EBF4FF" alt="">
                                     </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $application->user->name ?? 'N/A' }}</div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">{{ $application->user->email ?? 'N/A' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $application->job->title ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $application->created_at->format('Y-m-d') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    {{ $application->status === 'approved' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' :
                                       ($application->status === 'rejected' ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300' :
                                       'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300') }}">
                                    {{ ucfirst($application->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                 {{-- Quick Actions --}}
                                 @if($application->status === 'pending')
                                     <form action="{{ route('company.applications.approve', $application->id) }}" method="POST" class="inline-block">
                                         @csrf
                                         <button type="submit" class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300 transition-colors text-xs p-1 bg-green-100 dark:bg-green-900/50 rounded-full hover:bg-green-200">Approve</button>
                                     </form>
                                     <form action="{{ route('company.applications.reject', $application->id) }}" method="POST" class="inline-block">
                                         @csrf
                                         <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 transition-colors text-xs p-1 bg-red-100 dark:bg-red-900/50 rounded-full hover:bg-red-200">Reject</button>
                                     </form>
                                 @endif
                                 <a href="#" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">View</a>
                             </td>
                         </tr>
                    @empty
                         <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-sm text-gray-500 dark:text-gray-400">
                                No applications found.
                             </td>
                         </tr>
                     @endforelse
                 </tbody>
             </table>
         </div>
         {{-- Pagination Links --}}
         <div class="mt-6">
             {{ $applications->links() }}
         </div>
    </div>
</x-layouts.company> 