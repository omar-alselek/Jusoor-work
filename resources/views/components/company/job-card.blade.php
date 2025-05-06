@props(['job'])

<div class="relative group bg-white dark:bg-gray-800 rounded-lg shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden border border-transparent hover:border-brand-primary/50">
    <div class="p-5">
        <div class="flex justify-between items-start mb-2">
             <h3 class="text-lg font-semibold text-gray-900 dark:text-white group-hover:text-brand-primary transition-colors">
                <a href="{{ route('company.jobs.edit', $job->id) }}" class="focus:outline-none">
                    <span class="absolute inset-0" aria-hidden="true"></span>
                    {{ $job->title }}
                </a>
             </h3>
             <span class="text-xs font-medium px-2.5 py-0.5 rounded-full {{ $job->type === 'full_time' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : ($job->type === 'part_time' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300' : 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300') }}">
                {{ Str::title(str_replace('_', ' ', $job->type)) }}
             </span>
        </div>
        <p class="text-sm text-gray-600 dark:text-gray-400 mb-3 line-clamp-2">{{ $job->description }}</p>
        <div class="flex items-center justify-between text-xs text-gray-500 dark:text-gray-400 mb-4">
            <span><i class="fas fa-map-marker-alt mr-1 text-red-500"></i> {{ $job->location ?? 'Remote' }}</span>
            <span><i class="fas fa-calendar-alt mr-1 text-blue-500"></i> Posted: {{ $job->created_at->diffForHumans() }}</span>
        </div>
        <div class="mb-4">
            <h4 class="text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Skills:</h4>
            <div class="flex flex-wrap gap-1.5">
                @if(!empty($job->required_skills) && is_array($job->required_skills))
                    @foreach($job->required_skills as $skill)
                        <span class="inline-block bg-gradient-to-r from-indigo-100 to-blue-100 text-indigo-800 dark:from-indigo-900 dark:to-blue-900 dark:text-indigo-300 text-xs font-medium px-2.5 py-1 rounded-full shadow-sm hover:shadow-md transition-all duration-200">
                            {{ $skill }}
                        </span>
                    @endforeach
                @else
                    <span class="text-xs text-gray-400 italic">No specific skills listed</span>
                @endif
            </div>
        </div>
    </div>
     {{-- Animated Actions Overlay --}}
     <div class="absolute bottom-0 left-0 right-0 h-12 bg-gradient-to-t from-white/80 dark:from-gray-800/80 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-end px-4 space-x-2">
          <a href="{{ route('company.jobs.edit', $job->id) }}" class="p-1.5 rounded-full bg-blue-500 hover:bg-blue-600 text-white shadow-sm transition-colors text-xs">
             <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
         </a>
         <form action="{{ route('company.jobs.destroy', $job->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this job?');">
             @csrf
             @method('DELETE')
             <button type="submit" class="p-1.5 rounded-full bg-red-500 hover:bg-red-600 text-white shadow-sm transition-colors text-xs">
                 <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
             </button>
         </form>
     </div>
</div> 