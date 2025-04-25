@props(['title', 'value', 'icon'])

<div class="bg-light-bg dark:bg-gray-800 p-5 rounded-xl shadow-neumorphic-card hover:shadow-neumorphic-card-inset transition-shadow duration-300 group">
    <div class="flex items-center justify-between mb-3">
        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ $title }}</h3>
        <div class="p-2 bg-gradient-to-tr from-indigo-100 to-purple-100 dark:from-indigo-900/50 dark:to-purple-900/50 rounded-full text-brand-primary dark:text-indigo-300 group-hover:scale-110 transition-transform duration-300">
            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                 <path stroke-linecap="round" stroke-linejoin="round" d="{{ $icon }}" />
            </svg>
        </div>
    </div>
    <p class="text-3xl font-bold text-gray-800 dark:text-gray-100 group-hover:text-brand-primary transition-colors duration-300">{{ $value }}</p>
    {{-- Optional: Add a small description or link --}}
    {{-- <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">View details</p> --}}
</div> 