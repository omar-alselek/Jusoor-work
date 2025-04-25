<x-layouts.company>
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl p-6 md:p-8 border border-gray-200 dark:border-gray-700">
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white mb-6">
            {{ isset($job) ? 'Edit Job Opportunity' : 'Create New Job Opportunity' }}
        </h1>

         <form method="POST" action="{{ isset($job) ? route('company.jobs.update', $job->id) : route('company.jobs.store') }}" class="space-y-6">
            @csrf
            @if(isset($job))
                @method('PUT')
            @endif

            <x-form.input name="title" label="Job Title" :value="old('title', $job->title ?? '')" required />

            <div>
                <label for="description" class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Description</label>
                 <textarea id="description" name="description" rows="4" required
                           class="block w-full border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-transparent sm:text-sm transition shadow-sm">{{ old('description', $job->description ?? '') }}</textarea>
                 @error('description') <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
            </div>

             <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <x-form.input name="skills" label="Required Skills (comma-separated)" :value="old('skills', isset($job) ? implode(', ', $job->skills ?? []) : '')" placeholder="e.g., PHP, Laravel, MySQL" />
                <x-form.input name="salary" label="Salary/Compensation (Optional)" :value="old('salary', $job->salary ?? '')" placeholder="e.g., $50k - $70k or Competitive" />
                <x-form.select name="type" label="Job Type" required :options="['full_time' => 'Full-time', 'part_time' => 'Part-time', 'internship' => 'Internship', 'contract' => 'Contract']" :selected="old('type', $job->type ?? '')" />
                <x-form.input name="location" label="Location (leave blank for remote)" :value="old('location', $job->location ?? '')" />
             </div>

             {{-- Add deadline field if needed --}}
             {{-- <x-form.input name="deadline" type="date" label="Application Deadline" :value="old('deadline', isset($job) ? $job->deadline?->format('Y-m-d') : '')" /> --}}

            {{-- Action Buttons --}}
            <div class="flex justify-end pt-4 border-t border-gray-200 dark:border-gray-700">
                 <a href="{{ route('company.jobs.index') }}" class="bg-white dark:bg-gray-700 py-2 px-4 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mr-3">
                    Cancel
                </a>
                <button type="submit" class="inline-flex justify-center py-2 px-6 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-gradient-to-r from-brand-primary to-brand-secondary hover:from-brand-secondary hover:to-brand-primary focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-primary transition-all duration-300">
                    {{ isset($job) ? 'Update Job' : 'Post Job' }}
                </button>
            </div>
        </form>
    </div>
</x-layouts.company> 