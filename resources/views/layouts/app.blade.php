<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Jusoor Work') }}</title>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="font-sans antialiased bg-gray-50 min-h-screen flex flex-col">
    <!-- Header -->
    <header class="bg-gradient-to-r from-purple-600 to-purple-500 shadow-lg sticky top-0 z-30">
        <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between">
            <a href="/" class="text-2xl font-bold text-white tracking-wide drop-shadow">Jusoor Work</a>
            @auth
            <div class="flex items-center gap-4">
                <!-- Notifications Dropdown -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="text-white hover:text-indigo-100 transition relative">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        <span id="notification-badge" class="hidden absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-4 w-4 flex items-center justify-center">0</span>
                    </button>
                    <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg py-2 z-50">
                        <div id="notifications-container" class="max-h-96 overflow-y-auto">
                            <!-- Notifications will be loaded here -->
                        </div>
                    </div>
                </div>
                <!-- Chat Link -->
                <a href="{{ route('chat.index') }}" class="text-white hover:text-indigo-100 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                </a>
                <!-- User Dropdown -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center gap-2 bg-white/20 px-3 py-1 rounded-full focus:outline-none">
                        <img src="{{ auth()->user()->profile_photo_path ? asset('storage/' . auth()->user()->profile_photo_path) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&color=7F9CF5&background=EBF4FF' }}" class="h-10 w-10 rounded-full object-cover border-2 border-white shadow" alt="Profile Photo">
                        <span class="font-semibold text-white text-lg">{{ auth()->user()->name }}</span>
                        <svg class="w-4 h-4 text-white ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                    </button>
                    <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 z-50">
                        <a href="{{ route('company.profile.edit') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Profile</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-red-600 hover:bg-gray-100">Logout</button>
                        </form>
                    </div>
                </div>
            </div>
            @endauth
            @guest
            <a href="{{ route('login') }}" class="bg-white text-indigo-700 font-semibold px-5 py-2 rounded-lg shadow hover:bg-indigo-50 transition">Login</a>
            @endguest
        </div>
    </header>
    <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 pt-4 md:pt-0">
        <div class="px-4 sm:px-6 lg:px-8 py-4 md:py-8 mx-auto max-w-7xl">
            @yield('content')
        </div>
    </main>
    <!-- Footer -->
    <footer class="bg-white border-t mt-8 py-4 text-center text-gray-500 text-sm shadow-inner">
        &copy; {{ date('Y') }} Jusoor Work. All rights reserved.
    </footer>
    @stack('scripts')
    <div id="toast-notification" style="display:none;position:fixed;bottom:30px;right:30px;z-index:9999;min-width:250px;" class="bg-indigo-600 text-white px-6 py-4 rounded-lg shadow-lg flex items-center gap-3 animate-bounce">
        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M12 20a8 8 0 100-16 8 8 0 000 16z" /></svg>
        <div>
            <div id="toast-title" class="font-bold"></div>
            <div id="toast-message" class="text-sm"></div>
        </div>
    </div>
    <script>
        // Initialize Pusher
        window.pusher = new Pusher('{{ config('broadcasting.connections.pusher.key') }}', {
            cluster: '{{ config('broadcasting.connections.pusher.options.cluster') }}'
        });

        // Subscribe to notifications channel
        const notificationsChannel = window.pusher.subscribe('notifications-channel');
        notificationsChannel.bind('new-notification', function(data) {
            if (data.notification.user_id == {{ auth()->id() }}) {
                updateNotificationBadge();
                loadNotifications();
                showToastNotification(data.notification.title, data.notification.message);
            }
        });

        // Subscribe to chat channel
        const chatChannel = window.pusher.subscribe('chat-channel');
        chatChannel.bind('new-message', function(data) {
            if (data.message.receiver_id == {{ auth()->id() }}) {
                showMessageNotification(data.message);
            }
        });

        function updateNotificationBadge() {
            $.get('/notifications', function(notifications) {
                const unreadCount = notifications.filter(n => !n.is_read).length;
                const badge = $('#notification-badge');
                if (unreadCount > 0) {
                    badge.text(unreadCount).removeClass('hidden');
                } else {
                    badge.addClass('hidden');
                }
            });
        }

        function loadNotifications() {
            $.get('/notifications', function(notifications) {
                const container = $('#notifications-container');
                container.empty();
                
                if (notifications.length === 0) {
                    container.append('<div class="px-4 py-2 text-gray-500">No notifications</div>');
                    return;
                }

                notifications.forEach(notification => {
                    const html = `
                        <div class="px-4 py-2 hover:bg-gray-50 ${notification.is_read ? 'opacity-75' : ''}" data-id="${notification.id}">
                            <div class="flex items-start">
                                <div class="flex-1">
                                    <h4 class="text-sm font-medium text-gray-900">${notification.title}</h4>
                                    <p class="text-xs text-gray-500">${notification.message}</p>
                                    <span class="text-xs text-gray-400">${new Date(notification.created_at).toLocaleString()}</span>
                                </div>
                                ${!notification.is_read ? `
                                    <button onclick="markAsRead(${notification.id})" class="text-xs text-indigo-600 hover:text-indigo-800">
                                        Mark as read
                                    </button>
                                ` : ''}
                            </div>
                        </div>
                    `;
                    container.append(html);
                });
            });
        }

        function markAsRead(id) {
            $.ajax({
                url: `/notifications/${id}/read`,
                method: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function() {
                    updateNotificationBadge();
                    loadNotifications();
                }
            });
        }

        function showMessageNotification(message) {
            const notification = {
                user_id: {{ auth()->id() }},
                title: 'New Message',
                message: `You have a new message from ${message.sender.name}`,
                type: 'info'
            };

            $.ajax({
                url: '/notifications',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: notification,
                success: function() {
                    updateNotificationBadge();
                }
            });
        }

        function showToastNotification(title, message) {
            const toast = document.getElementById('toast-notification');
            document.getElementById('toast-title').textContent = title;
            document.getElementById('toast-message').textContent = message;
            toast.style.display = 'flex';
            setTimeout(() => { toast.style.display = 'none'; }, 5000);
        }

        // Load notifications on page load
        $(document).ready(function() {
            updateNotificationBadge();
            loadNotifications();
        });
    </script>
</body>
</html> 