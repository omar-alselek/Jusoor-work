{{-- resources/views/components/company/header.blade.php --}}
<header class="sticky top-0 z-30">
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16 md:h-20 bg-white/80 dark:bg-gray-800/80 backdrop-filter backdrop-blur-lg shadow-sm rounded-b-xl border border-t-0 border-gray-200 dark:border-gray-700 mx-4 md:mx-6 lg:mx-8">

            <!-- Header left: Sidebar toggle and Welcome -->
            <div class="flex items-center pl-4">
                 <!-- Sidebar Toggler -->
                 <button
                    class="text-gray-500 hover:text-gray-600 dark:text-gray-400 dark:hover:text-gray-300 lg:hidden mr-3"
                    @click.stop="sidebarOpen = !sidebarOpen"
                    aria-controls="sidebar"
                    :aria-expanded="sidebarOpen">
                    <span class="sr-only">Open sidebar</span>
                    <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <rect x="4" y="5" width="16" height="2" />
                        <rect x="4" y="11" width="16" height="2" />
                        <rect x="4" y="17" width="16" height="2" />
                    </svg>
                </button>
                <h1 class="text-lg font-semibold text-gray-700 dark:text-gray-200 hidden sm:block">
                    Welcome, {{ Auth::user()->name }}
                </h1>
            </div>

            <!-- Header right: Notifications, User menu -->
            <div class="flex items-center space-x-4">
                <!-- Notifications -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="relative text-gray-500 dark:text-gray-400 hover:text-brand-primary dark:hover:text-brand-primary p-2 rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-primary transition duration-150 ease-in-out">
                        <span class="sr-only">View notifications</span>
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341A6.002 6.002 0 006 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                        {{-- Add notification count badge if needed --}}
                        {{-- <span class="absolute top-0 right-0 block h-2 w-2 rounded-full ring-2 ring-white bg-red-500"></span> --}}
                    </button>
                    <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-80 bg-white dark:bg-gray-700 rounded-lg shadow-xl overflow-hidden z-10" style="display: none;">
                        <div class="p-4 font-semibold text-gray-800 dark:text-gray-100 border-b dark:border-gray-600">Notifications</div>
                        <div class="divide-y divide-gray-100 dark:divide-gray-600 max-h-80 overflow-y-auto">
                            {{-- Example Notification Item --}}
                            <a href="#" class="block px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <p class="text-sm font-medium text-gray-900 dark:text-white">Application Received</p>
                                <p class="text-xs text-gray-500 dark:text-gray-300">John Doe applied for Software Engineer</p>
                            </a>
                            <a href="#" class="block px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-600">
                                 <p class="text-sm font-medium text-gray-900 dark:text-white">Profile Approved</p>
                                 <p class="text-xs text-gray-500 dark:text-gray-300">Your company profile is now live!</p>
                             </a>
                            {{-- Add more notifications here --}}
                            <div class="p-4 text-center text-xs text-gray-500 dark:text-gray-400">No new notifications</div>
                        </div>
                        <a href="#" class="block bg-gray-50 dark:bg-gray-600 hover:bg-gray-100 dark:hover:bg-gray-500 p-2 text-center text-xs font-medium text-brand-primary dark:text-indigo-300">
                            View All Notifications
                        </a>
                    </div>
                </div>

                <!-- User Dropdown -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-primary" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                        <span class="sr-only">Open user menu</span>
                         {{-- Replace with actual user avatar --}}
                        <img class="h-9 w-9 rounded-full object-cover" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&color=7F9CF5&background=EBF4FF" alt="{{ Auth::user()->name }}">
                        <span class="hidden lg:block ml-2 text-gray-700 dark:text-gray-200">{{ Auth::user()->name }}</span>
                        <svg class="hidden lg:block ml-1 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"> <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                    </button>

                    <div x-show="open"
                         @click.away="open = false"
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="transform opacity-0 scale-95"
                         x-transition:enter-end="transform opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="transform opacity-100 scale-100"
                         x-transition:leave-end="transform opacity-0 scale-95"
                         class="absolute right-0 mt-2 w-48 origin-top-right bg-white dark:bg-gray-700 rounded-md shadow-lg py-1 ring-1 ring-black ring-opacity-5 focus:outline-none z-10"
                         role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1"
                         style="display: none;">
                        <a href="{{ route('company.profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600" role="menuitem" tabindex="-1">Your Profile</a>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600" role="menuitem" tabindex="-1">Settings</a>
                        <!-- Logout -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20" role="menuitem" tabindex="-1">
                                Sign out
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header> 