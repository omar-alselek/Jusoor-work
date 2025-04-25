<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard - Jusoor Work Platform</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gray-100">
    <div class="min-h-screen">
        <!-- Navigation -->
        <nav class="bg-white shadow-lg">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <div class="flex-shrink-0 flex items-center">
                            <span class="text-2xl font-bold text-indigo-600">Jusoor Work</span>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-gray-700 hover:text-indigo-600 px-3 py-2 rounded-md text-sm font-medium">Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg p-6">
                <h1 class="text-2xl font-bold text-gray-900 mb-4">Welcome, {{ Auth::user()->name }}!</h1>
                
                @if(Auth::user()->role === 'company')
                    <p class="mb-4">Redirecting you to the company dashboard...</p>
                    <script>window.location.href = "{{ route('company.dashboard') }}";</script>
                @elseif(Auth::user()->role === 'student')
                    <p class="mb-4">Redirecting you to the student dashboard...</p>
                    <script>window.location.href = "{{ route('student.dashboard') }}";</script>
                @elseif(Auth::user()->role === 'job_seeker')
                    <p class="mb-4">Redirecting you to the job seeker dashboard...</p>
                    <script>window.location.href = "{{ route('job_seeker.dashboard') }}";</script>
                @elseif(Auth::user()->role === 'admin')
                    <p class="mb-4">Redirecting you to the admin dashboard...</p>
                    <script>window.location.href = "{{ route('admin.dashboard') }}";</script>
                @else
                    <p class="text-gray-600">This is your dashboard. You can access various features of the platform from here.</p>
                    <ul class="mt-4 list-disc list-inside text-gray-600">
                        <li>Manage your profile</li>
                        <li>View available opportunities</li>
                        <li>Track your applications</li>
                    </ul>
                @endif
            </div>
        </main>
    </div>
</body>
</html> 