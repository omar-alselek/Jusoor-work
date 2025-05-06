{{-- Form content for creating/editing jobs --}}
<div class="max-w-4xl mx-auto" x-data="{ opportunityType: '{{ old('type', $job->type ?? '') }}' }">
    <div class="bg-white dark:bg-gray-800 shadow-xl rounded-2xl p-8 border border-gray-200 dark:border-gray-700 transition-all duration-300 hover:shadow-2xl">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-8 relative">
            {{ isset($job) ? 'Edit Job Opportunity' : 'Create New Job Opportunity' }}
            <div class="absolute bottom-0 left-0 w-20 h-1 bg-gradient-to-r from-brand-primary to-brand-secondary"></div>
        </h1>

        <p class="text-gray-600 dark:text-gray-400 mb-6">
            Fill in the details below to create a new opportunity. Make sure to provide clear and accurate information to help applicants understand the role better.
        </p>

        <form method="POST" action="{{ isset($job) ? route('company.jobs.update', $job->id) : route('company.jobs.store') }}" class="space-y-8">
            @csrf
            @if(isset($job))
                @method('PUT')
            @endif

            <div class="space-y-6">
                <!-- Job Type - Moved to top for better UX -->
                <div class="group">
                    <x-form.select 
                        name="type" 
                        label="Opportunity Type" 
                        required 
                        x-model="opportunityType"
                        :options="[
                            'full-time' => 'Full-Time Job',
                            'part-time' => 'Part-Time Job',
                            'internship' => 'Internship'
                        ]" 
                        :selected="old('type', $job->type ?? '')"
                        class="transform transition-all focus:scale-[1.01]"
                    />
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Select the type of opportunity to help match with applicants' needs</p>
                </div>

                <!-- Job Title -->
                <div class="group">
                    <x-form.input 
                        name="title" 
                        label="Opportunity Title" 
                        :value="old('title', $job->title ?? '')" 
                        required 
                        maxlength="100"
                        class="transform transition-all focus:scale-[1.01]"
                        placeholder="e.g., Junior Web Developer, Summer Marketing Internship"
                    />
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Maximum 100 characters. This will appear as the main title in opportunity listings.</p>
                </div>

                <!-- Description -->
                <div class="group">
                    <label for="description" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Description
                        <span class="text-red-500">*</span>
                    </label>
                    <textarea 
                        id="description" 
                        name="description" 
                        rows="6" 
                        required
                        maxlength="1000"
                        placeholder="Describe the key responsibilities, nature of work, and objectives of the opportunity..."
                        class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-transparent sm:text-sm transition-all duration-300 hover:border-brand-primary resize-y min-h-[150px]"
                    >{{ old('description', $job->description ?? '') }}</textarea>
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Maximum 1000 characters. Include detailed information about the role and its objectives.</p>
                    @error('description') 
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400 animate-fade-in">{{ $message }}</p> 
                    @enderror
                </div>

                <!-- Requirements -->
                <div class="group">
                    <label for="requirements" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Requirements
                        <span class="text-red-500">*</span>
                    </label>
                    <textarea 
                        id="requirements" 
                        name="requirements" 
                        rows="4" 
                        required
                        maxlength="1000"
                        placeholder="List technical skills, soft skills, and years of experience required..."
                        class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-transparent sm:text-sm transition-all duration-300 hover:border-brand-primary resize-y"
                    >{{ old('requirements', $job->requirements ?? '') }}</textarea>
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Maximum 1000 characters. Specify qualifications, experience levels, and any mandatory requirements.</p>
                </div>

                <!-- Two Column Layout -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Required Skills -->
                    <div class="group">
                        <x-form.input 
                            name="required_skills" 
                            label="Required Skills" 
                            :value="old('required_skills', isset($job) ? implode(', ', $job->required_skills ?? []) : '')" 
                            required
                            placeholder="e.g., Python, Marketing, Communication"
                            class="transform transition-all focus:scale-[1.01]"
                        />
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Separate skills with commas. Include both technical and soft skills.</p>
                    </div>

                    <!-- Location -->
                    <div class="group">
                        <x-form.input 
                            name="location" 
                            label="Location" 
                            :value="old('location', $job->location ?? '')" 
                            required
                            placeholder="City, Country or Remote"
                            class="transform transition-all focus:scale-[1.01]"
                        />
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Specify physical location or enter 'Remote' for remote work</p>
                    </div>

                    <!-- Salary -->
                    <div class="group">
                        <x-form.input 
                            name="salary" 
                            label="Salary" 
                            :value="old('salary', $job->salary ?? '')" 
                            placeholder="e.g., 1000 USD/month, 15 USD/hour, Negotiable"
                            class="transform transition-all focus:scale-[1.01]"
                        />
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Optional. Leave blank if unpaid internship. You can specify rate per hour/month or mark as negotiable.</p>
                    </div>

                    <!-- Working Hours -->
                    <div class="group">
                        <x-form.input 
                            name="working_hours" 
                            label="Working Hours" 
                            :value="old('working_hours', $job->working_hours ?? '')" 
                            placeholder="e.g., 20 hours/week, Flexible"
                            class="transform transition-all focus:scale-[1.01]"
                        />
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Required for part-time jobs and internships. Specify hours per week or flexibility.</p>
                    </div>
                </div>

                <!-- Internship Specific Fields -->
                <div x-show="opportunityType === 'internship'" 
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 transform -translate-y-4"
                     x-transition:enter-end="opacity-100 transform translate-y-0"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 transform translate-y-0"
                     x-transition:leave-end="opacity-0 transform -translate-y-4"
                     class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-6 space-y-6">
                    
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-brand-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Internship Details
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Duration -->
                        <div class="group">
                            <label for="duration" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Duration
                                <span class="text-red-500">*</span>
                            </label>
                            <select 
                                id="duration"
                                name="duration" 
                                required
                                x-bind:required="opportunityType === 'internship'"
                                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-600 focus:outline-none focus:ring-brand-primary focus:border-brand-primary sm:text-sm rounded-md dark:bg-gray-700 dark:text-gray-100 transition-all duration-200"
                            >
                                <option value="">Select Duration</option>
                                <option value="1_month" {{ old('duration', $job->duration ?? '') === '1_month' ? 'selected' : '' }}>1 Month</option>
                                <option value="3_months" {{ old('duration', $job->duration ?? '') === '3_months' ? 'selected' : '' }}>3 Months</option>
                                <option value="6_months" {{ old('duration', $job->duration ?? '') === '6_months' ? 'selected' : '' }}>6 Months</option>
                                <option value="custom" {{ old('duration', $job->duration ?? '') === 'custom' ? 'selected' : '' }}>Custom Duration</option>
                            </select>
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Select the duration of the internship program</p>
                        </div>

                        <!-- Academic Credit -->
                        <div class="group">
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Academic Credit</label>
                            <div class="mt-2 space-x-4">
                                <label class="inline-flex items-center">
                                    <input type="radio" name="academic_credit" value="1" class="form-radio" {{ old('academic_credit', $job->academic_credit ?? '') ? 'checked' : '' }}>
                                    <span class="ml-2">Yes</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="academic_credit" value="0" class="form-radio" {{ old('academic_credit', $job->academic_credit ?? '') === false ? 'checked' : '' }}>
                                    <span class="ml-2">No</span>
                                </label>
                            </div>
                            <p class="mt-1 text-xs text-gray-500">Indicate if this internship can be credited towards university requirements</p>
                        </div>
                    </div>
                </div>

                <!-- Dates -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Start Date -->
                    <div class="group">
                        <x-form.input 
                            type="date" 
                            name="start_date" 
                            label="Start Date" 
                            :value="old('start_date', isset($job) ? $job->start_date?->format('Y-m-d') : '')"
                            class="transform transition-all focus:scale-[1.01]"
                        />
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">When is the expected start date for this opportunity?</p>
                    </div>

                    <!-- Application Deadline -->
                    <div class="group">
                        <x-form.input 
                            type="date" 
                            name="deadline" 
                            label="Application Deadline" 
                            :value="old('deadline', isset($job) ? $job->deadline?->format('Y-m-d') : '')"
                            class="transform transition-all focus:scale-[1.01]"
                        />
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Last date for candidates to submit their applications</p>
                    </div>
                </div>

                <!-- Benefits -->
                <div class="group">
                    <label for="benefits" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Benefits
                    </label>
                    <textarea 
                        id="benefits" 
                        name="benefits" 
                        rows="3"
                        maxlength="500"
                        placeholder="List additional benefits (e.g., health insurance, paid leave, remote work options, training opportunities)..."
                        class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-transparent sm:text-sm transition-all duration-300 hover:border-brand-primary resize-y"
                    >{{ old('benefits', $job->benefits ?? '') }}</textarea>
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Maximum 500 characters. Highlight any additional perks or benefits offered with this opportunity.</p>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end pt-6 border-t border-gray-200 dark:border-gray-700 space-x-4">
                <a href="{{ route('company.jobs.index') }}" 
                    class="px-6 py-3 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-primary transition-all duration-300">
                    Cancel
                </a>
                <button type="submit" 
                    class="relative px-8 py-3 rounded-lg text-base font-bold text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-300 transform hover:scale-[1.02] shadow-lg hover:shadow-xl overflow-hidden group">
                    <span class="relative z-10 flex items-center justify-center">
                        {{ isset($job) ? 'Update Opportunity' : 'Post Opportunity' }}
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                    </span>
                    <div class="absolute inset-0 bg-white/20 transform -skew-x-12 -translate-x-full group-hover:translate-x-full transition-transform duration-700"></div>
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    // Add any additional JavaScript if needed
</script>
@endpush 