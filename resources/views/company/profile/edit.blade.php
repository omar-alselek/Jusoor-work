<x-layouts.company>
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl p-6 md:p-8 border border-gray-200 dark:border-gray-700">
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white mb-6">Edit Company Profile</h1>

        <form method="POST" action="{{ route('company.profile.update') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PATCH') {{-- Or PUT --}}

             {{-- Company Info Section --}}
            <div class="border-b border-gray-200 dark:border-gray-700 pb-6">
                 <h2 class="text-lg font-medium text-gray-900 dark:text-white mb-1">Company Information</h2>
                 <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Update your company's basic information.</p>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <x-form.input name="company_name" label="Company Name" :value="Auth::user()->company->company_name" required />
                    <x-form.input name="field_of_work" label="Field of Work" :value="Auth::user()->company->field_of_work" required />
                    <x-form.select name="company_size" label="Company Size" :options="['small' => 'Small (1-50)', 'medium' => 'Medium (51-250)', 'large' => 'Large (251+)']" :selected="Auth::user()->company->company_size" required />
                    <x-form.input name="location" label="Location" :value="Auth::user()->company->location" required />
                     <x-form.input name="company_email" type="email" label="Contact Email" :value="Auth::user()->company->company_email" required />
                     {{-- Add more fields as needed --}}
                </div>
             </div>

             {{-- Branding Section --}}
             <div class="border-b border-gray-200 dark:border-gray-700 pb-6">
                 <h2 class="text-lg font-medium text-gray-900 dark:text-white mb-1">Branding</h2>
                 <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Upload your company logo and environment photos.</p>
                 <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                     {{-- Logo Upload --}}
                     <div x-data="{ logoPreview: '{{ Auth::user()->company->logo_path ? Storage::url(Auth::user()->company->logo_path) : '' }}' }">
                         <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Company Logo</label>
                         <div class="mt-1 flex items-center space-x-4">
                            <span class="inline-block h-16 w-16 rounded-lg overflow-hidden bg-gray-100 dark:bg-gray-700">
                                <img x-show="logoPreview" :src="logoPreview" alt="Company Logo Preview" class="h-full w-full object-contain">
                                 <svg x-show="!logoPreview" class="h-full w-full text-gray-300 dark:text-gray-500" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                 </svg>
                            </span>
                             <label for="company_logo" class="cursor-pointer ml-5 bg-white dark:bg-gray-700 py-2 px-3 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm leading-4 font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-primary">
                                 <span>Change Logo</span>
                                <input id="company_logo" name="company_logo" type="file" class="sr-only" accept="image/*"
                                        @change="logoPreview = URL.createObjectURL($event.target.files[0])">
                            </label>
                        </div>
                         @error('company_logo') <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                     </div>

                     {{-- Environment Photos Upload (Example - could be more complex) --}}
                     <div>
                        <x-form.file-upload name="environment_photos[]" label="Work Environment Photos (Multiple)" accept="image/*" multiple info="Upload up to 5 images">
                             {{-- Show existing photos here --}}
                             @if(!empty(Auth::user()->company->environment_photos))
                                 <div class="flex flex-wrap gap-2 mt-2">
                                     @foreach(Auth::user()->company->environment_photos as $photoPath)
                                         <img src="{{ Storage::url($photoPath) }}" alt="Environment Photo" class="h-16 w-16 object-cover rounded-md border dark:border-gray-600">
                                     @endforeach
                                 </div>
                             @endif
                         </x-form.file-upload>
                     </div>
                 </div>
             </div>


             {{-- Verification Documents Section (Conditional) --}}
             @if(Auth::user()->company->status === 'pending')
             <div class="border-b border-gray-200 dark:border-gray-700 pb-6">
                 <h2 class="text-lg font-medium text-gray-900 dark:text-white mb-1">Verification Documents</h2>
                 <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Please upload the required documents to verify your company account.</p>

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
                 <button type="button" class="bg-white dark:bg-gray-700 py-2 px-4 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mr-3">
                    Cancel
                </button>
                <button type="submit" class="inline-flex justify-center py-2 px-6 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-gradient-to-r from-brand-primary to-brand-secondary hover:from-brand-secondary hover:to-brand-primary focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-primary transition-all duration-300">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</x-layouts.company> 