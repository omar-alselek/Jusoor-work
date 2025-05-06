<x-layouts.company>
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl p-6 md:p-8 border border-gray-200 dark:border-gray-700">
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white mb-6 relative pb-2 after:content-[''] after:absolute after:bottom-0 after:left-0 after:w-20 after:h-1 after:bg-gradient-to-r after:from-brand-primary after:to-brand-secondary">Edit Company Profile</h1>

        <form method="POST" action="{{ route('company.profile.update') }}" enctype="multipart/form-data" class="space-y-8">
            @csrf
            @method('PATCH')

             {{-- Company Info Section --}}
            <div class="border-b border-gray-200 dark:border-gray-700 pb-8">
                 <h2 class="text-lg font-medium text-gray-900 dark:text-white mb-1">Company Information</h2>
                 <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">Update your company's basic information.</p>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4">
                    <x-form.input name="company_name" label="Company Name" :value="Auth::user()->company->company_name" required />
                    <x-form.input name="field_of_work" label="Field of Work" :value="Auth::user()->company->field_of_work" required />
                    <x-form.select name="company_size" label="Company Size" :options="['small' => 'Small (1-50)', 'medium' => 'Medium (51-250)', 'large' => 'Large (251+)']" :selected="Auth::user()->company->company_size" required />
                    <x-form.input name="location" label="Location" :value="Auth::user()->company->location" required />
                    <x-form.input name="company_email" type="email" label="Contact Email" :value="Auth::user()->company->company_email" required />
                </div>
             </div>

             {{-- Branding Section --}}
             <div class="border-b border-gray-200 dark:border-gray-700 pb-8">
                 <h2 class="text-lg font-medium text-gray-900 dark:text-white mb-1">Company Branding</h2>
                 <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">Upload your company logo to enhance your brand visibility.</p>
                 
                 {{-- Logo Upload - Improved UI --}}
                 <div x-data="{ logoPreview: '{{ Auth::user()->company->logo_path ? Storage::url(Auth::user()->company->logo_path) : '' }}' }" class="max-w-md mx-auto">
                     <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Company Logo</label>
                     <div class="mt-1 flex flex-col items-center space-y-4">
                        <div class="w-32 h-32 rounded-full overflow-hidden bg-gray-100 dark:bg-gray-700 border-4 border-white dark:border-gray-600 shadow-lg flex items-center justify-center">
                            <img x-show="logoPreview" :src="logoPreview" alt="Company Logo Preview" class="h-full w-full object-cover">
                            <svg x-show="!logoPreview" class="h-16 w-16 text-gray-300 dark:text-gray-500" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                         <label for="company_logo" class="cursor-pointer py-2.5 px-4 border border-gray-300 dark:border-gray-600 rounded-full shadow-sm text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-primary bg-white dark:bg-gray-700 transition-all duration-200 hover:shadow-md">
                             <span class="flex items-center">
                                <svg class="w-5 h-5 mr-2 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0l-4 4m4-4v12"/></svg>
                                {{ Auth::user()->company->logo_path ? 'Change Logo' : 'Upload Logo' }}
                             </span>
                            <input id="company_logo" name="company_logo" type="file" class="sr-only" accept="image/*"
                                    @change="logoPreview = URL.createObjectURL($event.target.files[0])">
                        </label>
                        @error('company_logo') <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                        <p class="text-xs text-gray-500 dark:text-gray-400 text-center">
                            <svg class="inline-block w-4 h-4 mr-1 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="font-medium">Max size:</span> 5 MB <br>
                            <span class="font-medium">Recommended dimensions:</span> Square, at least 200×200 pixels<br>
                            <span class="font-medium">Supported formats:</span> JPG, PNG, GIF
                        </p>
                    </div>
                 </div>
             </div>

             {{-- Verification Documents Section (Conditional) --}}
             @if(Auth::user()->company->status === 'pending')
             <div class="border-b border-gray-200 dark:border-gray-700 pb-8">
                 <h2 class="text-lg font-medium text-gray-900 dark:text-white mb-1">Verification Documents</h2>
                 <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">Please upload the required documents to verify your company account.</p>

                 {{-- Main Document --}}
                <x-form.file-upload name="document" label="Main Document" accept=".pdf,.jpg,.png" required>
                     {{-- Show existing main document link --}}
                     @if(Auth::user()->company->document_path)
                         <x-slot name="preview">
                             <div class="flex items-center space-x-2 bg-gray-100 dark:bg-gray-700 p-2 rounded-md">
                                 <svg class="h-5 w-5 text-gray-400 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                 <a href="{{ Storage::url(Auth::user()->company->document_path) }}" target="_blank" class="text-indigo-600 dark:text-indigo-400 hover:underline truncate flex-1">
                                     View Uploaded Document
                                 </a>
                             </div>
                         </x-slot>
                     @endif
                </x-form.file-upload>

                {{-- Additional Documents --}}
                <x-form.file-upload name="additional_documents[]" label="Additional Documents (Optional)" accept=".pdf,.jpg,.png" multiple info="Upload any other relevant documents">
                     {{-- Show existing additional documents --}}
                     @if(!empty(Auth::user()->company->additional_documents))
                         <x-slot name="preview">
                            <div class="mt-2 space-y-1">
                                 @foreach(Auth::user()->company->additional_documents as $index => $docPath)
                                    <div class="flex items-center space-x-2 bg-gray-100 dark:bg-gray-700 p-2 rounded-md">
                                         <svg class="h-5 w-5 text-gray-400 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                         <a href="{{ Storage::url($docPath) }}" target="_blank" class="text-indigo-600 dark:text-indigo-400 hover:underline truncate flex-1">
                                             Additional Document {{ $index + 1 }}
                                         </a>
                                    </div>
                                @endforeach
                            </div>
                         </x-slot>
                     @endif
                </x-form.file-upload>
             </div>
             @endif


            {{-- Action Buttons --}}
            <div class="flex justify-end pt-4">
                 <a href="{{ route('company.dashboard') }}" class="bg-white dark:bg-gray-700 py-2.5 px-5 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mr-4 transition-all duration-200">
                    Cancel
                </a>
                <button type="submit" class="inline-flex justify-center py-3.5 px-8 border border-transparent shadow-xl text-base font-bold rounded-lg text-white bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-300 transform hover:scale-105">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</x-layouts.company> 