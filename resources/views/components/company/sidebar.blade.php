{{-- resources/views/components/company/sidebar.blade.php --}}
<aside
    class="fixed inset-y-0 left-0 z-50 flex-shrink-0 bg-gradient-to-b from-indigo-700 to-purple-800 text-white transition-all duration-300 ease-in-out shadow-xl"
    :class="sidebarOpen ? 'w-64' : 'w-20'"
    @mouseenter="if (window.innerWidth > 1024) sidebarOpen = true"
    @mouseleave="if (window.innerWidth > 1024) sidebarOpen = false"
    >
    <div class="flex flex-col h-full">
        <!-- Logo -->
        <div class="h-20 flex items-center justify-center flex-shrink-0 px-4 border-b border-white/10" :class="!sidebarOpen && 'px-0'">
             <a href="{{ route('company.dashboard') }}" class="text-2xl font-bold transition-opacity duration-200" :class="sidebarOpen ? 'opacity-100' : 'opacity-0'">
                <span class="bg-white text-indigo-800 px-3 py-1 rounded-md shadow-lg font-bold">Work</span>
            </a>
             <a href="{{ route('company.dashboard') }}" class="text-2xl font-bold transition-opacity duration-200" :class="sidebarOpen ? 'opacity-0 h-0 w-0' : 'opacity-100'">
                 <span class="bg-white text-indigo-800 px-2 py-1 rounded-md shadow-lg text-lg font-bold">W</span>
            </a>
        </div>

        <!-- Mobile Menu Toggle - Only visible on mobile -->
        <div class="lg:hidden absolute top-4 right-4 z-50" x-data="{ open: false }">
            <button @click="open = !open; sidebarOpen = open" class="text-white p-2 rounded-md hover:bg-white/10 focus:outline-none">
                <svg x-show="!open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
                <svg x-show="open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <!-- Navigation Links -->
        <nav class="flex-1 mt-4 overflow-y-auto px-2 space-y-1">
            <x-company.sidebar-link route="company.dashboard" icon="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.125 1.125 0 010 2.25H5.625a1.125 1.125 0 010-2.25z">
                Dashboard
            </x-company.sidebar-link>
            <x-company.sidebar-link route="company.profile.edit" icon="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z">
                Company Profile
            </x-company.sidebar-link>
            <x-company.sidebar-link route="company.jobs.index" icon="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25">
                Job Management
            </x-company.sidebar-link>
             <x-company.sidebar-link route="company.applications.index" icon="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z">
                Applications
            </x-company.sidebar-link>
            <x-company.sidebar-link route="company.messages" icon="M17 8h2a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2v-8a2 2 0 012-2h2m10-4H7a2 2 0 00-2 2v0a2 2 0 002 2h10a2 2 0 002-2v0a2 2 0 00-2-2z">
                Messages
            </x-company.sidebar-link>
            <x-company.sidebar-link route="company.notifications" icon="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V4a2 2 0 10-4 0v.341C7.67 7.165 6 9.388 6 12v2.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                Notifications
            </x-company.sidebar-link>
        </nav>

        <!-- Footer -->
         <div class="p-4 mt-auto flex-shrink-0 border-t border-white/10 text-xs text-white/60">
            <div x-show="sidebarOpen" class="text-center">
                © {{ date('Y') }} {{ config('app.name') }}
            </div>
         </div>
    </div>
</aside> 