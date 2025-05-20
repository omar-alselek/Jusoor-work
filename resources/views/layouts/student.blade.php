<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Jusoor Work') }} - Student Dashboard</title>
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="font-sans antialiased bg-gray-50 min-h-screen flex flex-col">
    <!-- Header -->
    <header class="bg-gradient-to-r from-[#7b2ff2] to-[#6025c5] shadow-lg sticky top-0 z-30">
        <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between">
            <!-- Mobile menu button -->
            <button id="mobile-menu-button" class="md:hidden text-white focus:outline-none">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
            
            <!-- Logo -->
            <a href="{{ route('student.dashboard') }}" class="text-2xl font-bold text-white tracking-wide drop-shadow flex items-center">
                <span class="hidden sm:inline">Jusoor Work</span>
                <span class="sm:hidden">JW</span>
            </a>
            
            <!-- Right side navigation -->
            <div class="flex items-center gap-4">
                <!-- Notifications dropdown -->
                <div class="relative group hidden sm:block">
                    <a href="{{ route('student.notifications') }}" class="text-white hover:text-indigo-100 transition">
                        <div class="relative">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                            </svg>
                            @php
                                $unreadCount = auth()->user()->notifications->where('is_read', false)->count();
                            @endphp
                            @if($unreadCount > 0)
                                <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-4 w-4 flex items-center justify-center">{{ $unreadCount }}</span>
                            @endif
                        </div>
                    </a>
                </div>
                
                <!-- Messages link -->
                <div class="relative group hidden sm:block">
                    <a href="{{ route('student.messages') }}" class="text-white hover:text-indigo-100 transition">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                        </svg>
                    </a>
                </div>
                
                <!-- Profile dropdown -->
                <div class="relative group">
                    <button id="profileMenuBtn" type="button" class="focus:outline-none flex items-center">
                        <img src="{{ auth()->user()->profile_photo_path ? asset('storage/' . auth()->user()->profile_photo_path) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&color=7B2FF5&background=F357A8' }}" class="h-10 w-10 rounded-full object-cover border-2 border-white shadow cursor-pointer" alt="Profile Photo">
                        <span class="hidden sm:block text-white ml-2">{{ auth()->user()->name }}</span>
                        <svg class="hidden sm:block h-5 w-5 text-white ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div id="profileMenu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 z-50 border border-gray-100">
                        <div class="px-4 py-2 border-b border-gray-100">
                            <p class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email }}</p>
                        </div>
                        <a href="{{ route('student.dashboard') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            <svg class="mr-2 h-4 w-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                            Dashboard
                        </a>
                        <a href="{{ route('student.profile') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            <svg class="mr-2 h-4 w-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Profile
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="border-t border-gray-100 mt-1">
                            @csrf
                            <button type="submit" class="w-full flex items-center px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                <svg class="mr-2 h-4 w-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                </svg>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Mobile menu overlay -->    
    <div id="mobile-menu-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden"></div>
    
    <!-- Mobile menu -->    
    <div id="mobile-menu" class="fixed inset-y-0 left-0 w-64 bg-white shadow-lg transform -translate-x-full transition-transform duration-300 ease-in-out z-50">
        <div class="flex flex-col h-full">
            <div class="h-16 flex items-center justify-between px-4 border-b border-gray-100">
                <a href="{{ route('student.dashboard') }}" class="text-xl font-bold text-indigo-600">Jusoor Work</a>
                <button id="close-mobile-menu" class="text-gray-500 hover:text-gray-700 focus:outline-none">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <div class="p-4 border-b border-gray-100">
                <div class="flex items-center space-x-3">
                    <img src="{{ auth()->user()->profile_photo_path ? asset('storage/' . auth()->user()->profile_photo_path) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&color=7B2FF5&background=F357A8' }}" class="h-10 w-10 rounded-full object-cover border border-gray-200" alt="Profile Photo">
                    <div>
                        <p class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email }}</p>
                    </div>
                </div>
            </div>
            
            <nav class="flex-1 py-4 px-4 space-y-1 overflow-y-auto">
                <a href="{{ route('student.dashboard') }}" class="flex items-center px-3 py-3 text-gray-700 rounded-lg {{ request()->routeIs('student.dashboard') ? 'bg-indigo-50 text-indigo-600' : 'hover:bg-gray-50' }}">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('student.dashboard') ? 'text-indigo-500' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('student.profile') }}" class="flex items-center px-3 py-3 text-gray-700 rounded-lg {{ request()->routeIs('student.profile*') ? 'bg-indigo-50 text-indigo-600' : 'hover:bg-gray-50' }}">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('student.profile*') ? 'text-indigo-500' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    <span>Profile</span>
                </a>
                <a href="{{ route('student.opportunities') }}" class="flex items-center px-3 py-3 text-gray-700 rounded-lg {{ request()->routeIs('student.opportunities*') ? 'bg-indigo-50 text-indigo-600' : 'hover:bg-gray-50' }}">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('student.opportunities*') ? 'text-indigo-500' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    <span>Opportunities</span>
                </a>
                <a href="{{ route('student.messages') }}" class="flex items-center px-3 py-3 text-gray-700 rounded-lg {{ request()->routeIs('student.messages*') ? 'bg-indigo-50 text-indigo-600' : 'hover:bg-gray-50' }}">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('student.messages*') ? 'text-indigo-500' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                    </svg>
                    <span>Messages</span>
                </a>
                <a href="{{ route('student.notifications') }}" class="flex items-center px-3 py-3 text-gray-700 rounded-lg {{ request()->routeIs('student.notifications*') ? 'bg-indigo-50 text-indigo-600' : 'hover:bg-gray-50' }}">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('student.notifications*') ? 'text-indigo-500' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                    </svg>
                    <span>Notifications</span>
                </a>
                <a href="{{ route('student.ai-cv-analyzer') }}" class="flex items-center px-3 py-3 text-gray-700 rounded-lg {{ request()->routeIs('student.ai-cv-analyzer*') ? 'bg-indigo-50 text-indigo-600' : 'hover:bg-gray-50' }}">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('student.ai-cv-analyzer*') ? 'text-indigo-500' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                    </svg>
                    <div class="flex items-center">
                        <span>AI CV Analyzer</span>
                        <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-indigo-100 text-indigo-800">New</span>
                    </div>
                </a>
            </nav>
            
            <div class="p-4 border-t border-gray-100">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center px-3 py-3 text-sm text-red-600 hover:bg-gray-50 rounded-lg">
                        <svg class="mr-3 h-5 w-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="flex flex-1 min-h-0">
        @if(empty($hideSidebar))
            <!-- Desktop Sidebar -->            
            <aside id="sidebar" class="group w-20 hover:w-64 bg-white shadow-lg border-r border-gray-100 hidden md:block transition-all duration-300 overflow-x-hidden">
                <div class="flex flex-col h-full">
                    <div class="h-16 flex items-center justify-center border-b border-gray-100">
                        <a href="{{ route('student.dashboard') }}" class="text-xl font-bold text-indigo-600">
                            <span class="hidden group-hover:inline">Jusoor Work</span>
                            <span class="group-hover:hidden">JW</span>
                        </a>
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
                        <a href="{{ route('student.ai-cv-analyzer') }}" class="flex items-center px-2 py-3 text-gray-700 group rounded-lg {{ request()->routeIs('student.ai-cv-analyzer*') ? 'bg-indigo-50 text-indigo-600' : 'hover:bg-gray-50' }}">
                            <svg class="w-5 h-5 mr-0 group-hover:mr-3 {{ request()->routeIs('student.ai-cv-analyzer*') ? 'text-indigo-500' : 'text-gray-400 group-hover:text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                            </svg>
                            <div class="hidden group-hover:flex items-center">
                                <span>AI CV Analyzer</span>
                                <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-indigo-100 text-indigo-800">New</span>
                            </div>
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
        // Mobile menu functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Profile dropdown functionality
            const profileBtn = document.getElementById('profileMenuBtn');
            const profileMenu = document.getElementById('profileMenu');
            
            document.addEventListener('click', function(e) {
                if (profileBtn && profileBtn.contains(e.target)) {
                    profileMenu.classList.toggle('hidden');
                } else if (profileMenu && !profileMenu.contains(e.target)) {
                    profileMenu.classList.add('hidden');
                }
            });
            
            // Mobile menu functionality
            const mobileMenuBtn = document.getElementById('mobile-menu-button');
            const closeMobileMenuBtn = document.getElementById('close-mobile-menu');
            const mobileMenu = document.getElementById('mobile-menu');
            const mobileMenuOverlay = document.getElementById('mobile-menu-overlay');
            
            function openMobileMenu() {
                mobileMenu.classList.remove('-translate-x-full');
                mobileMenuOverlay.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            }
            
            function closeMobileMenu() {
                mobileMenu.classList.add('-translate-x-full');
                mobileMenuOverlay.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }
            
            if (mobileMenuBtn) {
                mobileMenuBtn.addEventListener('click', openMobileMenu);
            }
            
            if (closeMobileMenuBtn) {
                closeMobileMenuBtn.addEventListener('click', closeMobileMenu);
            }
            
            if (mobileMenuOverlay) {
                mobileMenuOverlay.addEventListener('click', closeMobileMenu);
            }
        });
        
        // Initialize Pusher globally for student layout
        if (typeof Pusher !== 'undefined' && !window.pusher) {
            window.pusher = new Pusher('{{ config('broadcasting.connections.pusher.key') }}', {
                cluster: '{{ config('broadcasting.connections.pusher.options.cluster') }}'
            });
        }
    </script>
</body>
</html> 