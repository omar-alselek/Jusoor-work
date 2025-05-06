{{-- Create job view --}}
<x-layouts.company>
    <div class="max-w-4xl mx-auto">
        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl p-6 md:p-8 border border-gray-200 dark:border-gray-700">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Post a New Job</h1>
                <p class="text-lg text-gray-600 dark:text-gray-400">Fill in the details below to create a new job opportunity.</p>
            </div>
            
            @include('company.jobs.form')
        </div>
    </div>
</x-layouts.company>
