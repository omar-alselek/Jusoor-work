<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Jusoor Work') }} - Student Dashboard</title>
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="font-sans antialiased bg-gray-50 min-h-screen flex flex-col">
    <!-- Header -->
    <header class="bg-[#7b2ff2] shadow-lg sticky top-0 z-30">
        <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between">
            <a href="{{ route('student.dashboard') }}" class="text-2xl font-bold text-white tracking-wide drop-shadow">Jusoor Work</a>
            <div class="relative flex items-center gap-4">
                <div class="relative group">
                    <button id="profileMenuBtn" type="button" class="focus:outline-none">
                        <img src="{{ auth()->user()->profile_photo_path ? asset('storage/' . auth()->user()->profile_photo_path) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&color=7B2FF5&background=F357A8' }}" class="h-12 w-12 rounded-full object-cover border-2 border-white shadow cursor-pointer" alt="Profile Photo">
                    </button>
                    <div id="profileMenu" class="hidden group-focus:block group-hover:block absolute right-0 mt-2 w-44 bg-white rounded-lg shadow-lg py-2 z-50">
                        <a href="{{ route('student.dashboard') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Dashboard</a>
                        <a href="{{ route('student.profile') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Profile</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-red-600 hover:bg-gray-100">Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const btn = document.getElementById('profileMenuBtn');
                const menu = document.getElementById('profileMenu');
                document.addEventListener('click', function(e) {
                    if (btn.contains(e.target)) {
                        menu.classList.toggle('hidden');
                    } else if (!menu.contains(e.target)) {
                        menu.classList.add('hidden');
                    }
                });
            });
        </script>
    </header>
    <div class="flex flex-1 min-h-0">
        @if(empty($hideSidebar))
            <!-- Sidebar -->
            <aside id="sidebar" class="group w-20 hover:w-64 bg-white shadow-lg border-r border-gray-100 hidden md:block transition-all duration-300 overflow-x-hidden">
                <div class="flex flex-col h-full">
                    <div class="h-16 flex items-center justify-center border-b border-gray-100">
                        <a href="{{ route('student.dashboard') }}" class="text-xl font-bold text-indigo-600"><span class="hidden group-hover:inline">Jusoor Work</span><span class="group-hover:hidden">JW</span></a>
                    </div>
                    <nav class="flex-1 py-6 px-2 space-y-1">
                        <a href="{{ route('student.dashboard') }}" class="flex items-center px-2 py-3 text-gray-700 group rounded-lg {{ request()->routeIs('student.dashboard') ? 'bg-indigo-50 text-indigo-600' : 'hover:bg-gray-50' }}">
                            <svg class="w-5 h-5 mr-0 group-hover:mr-3 {{ request()->routeIs('student.dashboard') ? 'text-indigo-500' : 'text-gray-400 group-hover:text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                            <span class="hidden group-hover:inline">Dashboard</span>
                        </a>
                        <a href="{{ route('student.profile') }}" class="flex items-center px-2 py-3 text-gray-700 group rounded-lg {{ request()->routeIs('student.profile*') ? 'bg-indigo-50 text-indigo-600' : 'hover:bg-gray-50' }}">
                            <svg class="w-5 h-5 mr-0 group-hover:mr-3 {{ request()->routeIs('student.profile*') ? 'text-indigo-500' : 'text-gray-400 group-hover:text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <span class="hidden group-hover:inline">Profile</span>
                        </a>
                        <a href="{{ route('student.opportunities') }}" class="flex items-center px-2 py-3 text-gray-700 group rounded-lg {{ request()->routeIs('student.opportunities*') ? 'bg-indigo-50 text-indigo-600' : 'hover:bg-gray-50' }}">
                            <svg class="w-5 h-5 mr-0 group-hover:mr-3 {{ request()->routeIs('student.opportunities*') ? 'text-indigo-500' : 'text-gray-400 group-hover:text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            <span class="hidden group-hover:inline">Opportunities</span>
                        </a>
                        <a href="{{ route('student.messages') }}" class="flex items-center px-2 py-3 text-gray-700 group rounded-lg {{ request()->routeIs('student.messages*') ? 'bg-indigo-50 text-indigo-600' : 'hover:bg-gray-50' }}">
                            <svg class="w-5 h-5 mr-0 group-hover:mr-3 {{ request()->routeIs('student.messages*') ? 'text-indigo-500' : 'text-gray-400 group-hover:text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                            </svg>
                            <span class="hidden group-hover:inline">Messages</span>
                        </a>
                        <a href="{{ route('student.notifications') }}" class="flex items-center px-2 py-3 text-gray-700 group rounded-lg {{ request()->routeIs('student.notifications*') ? 'bg-indigo-50 text-indigo-600' : 'hover:bg-gray-50' }}">
                            <svg class="w-5 h-5 mr-0 group-hover:mr-3 {{ request()->routeIs('student.notifications*') ? 'text-indigo-500' : 'text-gray-400 group-hover:text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                            </svg>
                            <span class="hidden group-hover:inline">Notifications</span>
                        </a>
                    </nav>
                </div>
            </aside>
        @endif
        <!-- Main content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 pt-4 md:pt-0">
                <div class="px-4 sm:px-6 lg:px-8 py-4 md:py-8 mx-auto max-w-7xl">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>
    <!-- Footer -->
    <footer class="bg-white border-t mt-8 py-4 text-center text-gray-500 text-sm shadow-inner">
        &copy; {{ date('Y') }} Jusoor Work. All rights reserved.
    </footer>
    @stack('scripts')
    <style>
        #sidebar {
            width: 5rem;
        }
        #sidebar:hover {
            width: 16rem;
        }
    </style>
    <script>
        // Initialize Pusher globally for student layout
        if (typeof Pusher !== 'undefined' && !window.pusher) {
            window.pusher = new Pusher('{{ config('broadcasting.connections.pusher.key') }}', {
                cluster: '{{ config('broadcasting.connections.pusher.options.cluster') }}'
            });
        }
    </script>
</body>
</html> 