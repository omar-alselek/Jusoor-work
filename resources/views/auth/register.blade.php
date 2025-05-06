<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register - Jusoor Work Platform</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <style>
        /* Style for checked radio label */
        input[type="radio"]:checked + label {
            border-color: #6366F1; /* indigo-600 */
            color: #6366F1; /* indigo-600 */
            background-color: #EEF2FF; /* indigo-100 */
        }
    </style>
</head>
<body class="bg-gradient-to-br from-gray-50 to-gray-100 dark:bg-[#0a0a0a]">
    <div class="min-h-screen flex flex-col justify-center items-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            <span class="text-4xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">Jusoor Work</span>
        </div>
        <div class="w-full max-w-2xl bg-white rounded-xl shadow-xl overflow-hidden">
            <div class="px-6 py-8 sm:px-10">
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-bold text-gray-900">Create Your Account</h2>
                    <p class="mt-2 text-sm text-gray-600">Join the platform to find opportunities or talent</p>
                </div>

                @if ($errors->any())
                    <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6 rounded-md">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-exclamation-circle text-red-400"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-red-700">
                                    Please correct the errors below.
                                </p>
                            </div>
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <!-- Role Selection -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">I am registering as a:</label>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <input type="radio" id="student" name="role" value="student" class="hidden peer" required {{ old('role') == 'student' ? 'checked' : '' }}>
                            <label for="student" class="flex flex-col items-center justify-center w-full p-4 text-center text-gray-600 bg-white border border-gray-300 rounded-lg cursor-pointer transition-colors duration-200 hover:bg-gray-50">
                                <i class="fas fa-graduation-cap text-2xl mb-2"></i>
                                <span class="font-medium">Student</span>
                            </label>

                            <input type="radio" id="company" name="role" value="company" class="hidden peer" {{ old('role') == 'company' ? 'checked' : '' }}>
                            <label for="company" class="flex flex-col items-center justify-center w-full p-4 text-center text-gray-600 bg-white border border-gray-300 rounded-lg cursor-pointer transition-colors duration-200 hover:bg-gray-50">
                                <i class="fas fa-building text-2xl mb-2"></i>
                                <span class="font-medium">Company</span>
                            </label>

                            <input type="radio" id="job_seeker" name="role" value="job_seeker" class="hidden peer" {{ old('role') == 'job_seeker' ? 'checked' : '' }}>
                            <label for="job_seeker" class="flex flex-col items-center justify-center w-full p-4 text-center text-gray-600 bg-white border border-gray-300 rounded-lg cursor-pointer transition-colors duration-200 hover:bg-gray-50">
                                <i class="fas fa-user-tie text-2xl mb-2"></i>
                                <span class="font-medium">Job Seeker</span>
                            </label>
                        </div>
                         @error('role') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Common Fields -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-user text-gray-400"></i>
                                </div>
                                <input id="name" name="name" type="text" autocomplete="name" required autofocus
                                    class="form-input block w-full pl-10 {{ $errors->has('name') ? 'border-red-500' : 'border-gray-300' }}"
                                    value="{{ old('name') }}">
                            </div>
                            @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                             <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-envelope text-gray-400"></i>
                                </div>
                                <input id="email" name="email" type="email" autocomplete="email" required
                                    class="form-input block w-full pl-10 {{ $errors->has('email') ? 'border-red-500' : 'border-gray-300' }}"
                                    value="{{ old('email') }}">
                            </div>
                            @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-lock text-gray-400"></i>
                                </div>
                                <input id="password" name="password" type="password" autocomplete="new-password" required
                                    class="form-input block w-full pl-10 {{ $errors->has('password') ? 'border-red-500' : 'border-gray-300' }}">
                            </div>
                            @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="password-confirm" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-lock text-gray-400"></i>
                                </div>
                                <input id="password-confirm" name="password_confirmation" type="password" autocomplete="new-password" required
                                    class="form-input block w-full pl-10 border-gray-300">
                            </div>
                        </div>
                    </div>

                    <!-- Student Fields -->
                    <div id="student-fields" class="hidden space-y-6 border-t border-gray-200 pt-6">
                         <h3 class="text-lg font-medium text-gray-900">Student Information</h3>
                         <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label for="university" class="block text-sm font-medium text-gray-700">University</label>
                                <input id="university" name="university" type="text" class="form-input mt-1 block w-full {{ $errors->has('university') ? 'border-red-500' : 'border-gray-300' }}" value="{{ old('university') }}">
                                @error('university') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="major" class="block text-sm font-medium text-gray-700">Major</label>
                                <input id="major" name="major" type="text" class="form-input mt-1 block w-full {{ $errors->has('major') ? 'border-red-500' : 'border-gray-300' }}" value="{{ old('major') }}">
                                @error('major') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                        <div>
                            <label for="academic_year" class="block text-sm font-medium text-gray-700">Academic Year</label>
                            <input id="academic_year" name="academic_year" type="text" class="form-input mt-1 block w-full {{ $errors->has('academic_year') ? 'border-red-500' : 'border-gray-300' }}" value="{{ old('academic_year') }}">
                            @error('academic_year') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <!-- Company Fields -->
                    <div id="company-fields" class="hidden space-y-6 border-t border-gray-200 pt-6">
                        <h3 class="text-lg font-medium text-gray-900">Company Information</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label for="company_name" class="block text-sm font-medium text-gray-700">Company Name</label>
                                <input id="company_name" name="company_name" type="text" class="form-input mt-1 block w-full {{ $errors->has('company_name') ? 'border-red-500' : 'border-gray-300' }}" value="{{ old('company_name') }}">
                                @error('company_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="field_of_work" class="block text-sm font-medium text-gray-700">Field of Work</label>
                                <input id="field_of_work" name="field_of_work" type="text" class="form-input mt-1 block w-full {{ $errors->has('field_of_work') ? 'border-red-500' : 'border-gray-300' }}" value="{{ old('field_of_work') }}">
                                @error('field_of_work') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="company_size" class="block text-sm font-medium text-gray-700">Company Size</label>
                                <select id="company_size" name="company_size" class="form-select mt-1 block w-full {{ $errors->has('company_size') ? 'border-red-500' : 'border-gray-300' }}">
                                    <option value="" {{ old('company_size') == '' ? 'selected' : '' }}>Select Company Size</option>
                                    <option value="1-10" {{ old('company_size') == '1-10' ? 'selected' : '' }}>1-10 employees</option>
                                    <option value="11-50" {{ old('company_size') == '11-50' ? 'selected' : '' }}>11-50 employees</option>
                                    <option value="51-200" {{ old('company_size') == '51-200' ? 'selected' : '' }}>51-200 employees</option>
                                    <option value="201-500" {{ old('company_size') == '201-500' ? 'selected' : '' }}>201-500 employees</option>
                                    <option value="501+" {{ old('company_size') == '501+' ? 'selected' : '' }}>501+ employees</option>
                                </select>
                                @error('company_size') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="location" class="block text-sm font-medium text-gray-700">Location</label>
                                <input id="location" name="location" type="text" class="form-input mt-1 block w-full {{ $errors->has('location') ? 'border-red-500' : 'border-gray-300' }}" value="{{ old('location') }}">
                                @error('location') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="company_email" class="block text-sm font-medium text-gray-700">Company Email</label>
                                <input id="company_email" name="company_email" type="email" class="form-input mt-1 block w-full {{ $errors->has('company_email') ? 'border-red-500' : 'border-gray-300' }}" value="{{ old('company_email') }}">
                                @error('company_email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700">Company Description</label>
                                <textarea id="description" name="description" rows="4" class="form-textarea mt-1 block w-full {{ $errors->has('description') ? 'border-red-500' : 'border-gray-300' }}">{{ old('description') }}</textarea>
                                @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="document" class="block text-sm font-medium text-gray-700">Company Document (PDF/JPG/PNG)</label>
                                <input id="document" name="document" type="file" accept=".pdf,.jpg,.jpeg,.png" class="form-input mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 {{ $errors->has('document') ? 'border-red-500' : 'border-gray-300' }}">
                                @error('document') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    <div>
                        <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200">
                            <i class="fas fa-user-plus mr-2"></i> Register
                        </button>
                    </div>
                </form>
            </div>
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 text-center">
                <p class="text-sm text-gray-600">
                    Already have an account? 
                    <a href="{{ route('login') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                        Login here
                    </a>
                </p>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const roleInputs = document.querySelectorAll('input[name="role"]');
            const studentFields = document.getElementById('student-fields');
            const companyFields = document.getElementById('company-fields');

            function toggleFields() {
                studentFields.classList.add('hidden', 'opacity-0');
                companyFields.classList.add('hidden', 'opacity-0');
                
                const checkedRole = document.querySelector('input[name="role"]:checked');
                if (checkedRole) {
                    if (checkedRole.value === 'student') {
                        studentFields.classList.remove('hidden');
                        setTimeout(() => studentFields.classList.remove('opacity-0'), 10); 
                    } else if (checkedRole.value === 'company') {
                        companyFields.classList.remove('hidden');
                         setTimeout(() => companyFields.classList.remove('opacity-0'), 10); 
                    }
                }
            }

            roleInputs.forEach(input => {
                input.addEventListener('change', toggleFields);
            });

            // Initial check on page load
            toggleFields();

            // Add transition classes for smooth visibility changes
            studentFields.classList.add('transition-opacity', 'duration-300');
            companyFields.classList.add('transition-opacity', 'duration-300');
        });
    </script>
</body>
</html> 