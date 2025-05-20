<x-layouts.company>
    <div class="container mx-auto px-4 py-6">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Notifications</h1>
            <p class="text-gray-600 dark:text-gray-400">Stay updated with applications, messages, and system updates.</p>
        </div>

        <div class="flex justify-between items-center mb-6">
            <div class="flex space-x-2">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200">
                    All
                </span>
            </div>
            
            @if(Auth::user()->notifications()->where('is_read', false)->count() > 0)
            <form id="mark-all-form" method="POST" action="/notifications/mark-all-read">
                @csrf
                @method('PUT')
                <button id="mark-all-read-btn" type="button" class="text-sm text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300 font-medium">
                    Mark all as read
                </button>
            </form>
            @endif
        </div>

        <div class="space-y-4">
            @php
                $notifications = Auth::user()->notifications()->orderBy('created_at', 'desc')->get();
            @endphp
            @forelse($notifications as $notification)
                <div class="rounded-xl shadow bg-white dark:bg-gray-800 {{ !$notification->is_read ? 'bg-indigo-50 dark:bg-indigo-900/20' : '' }} p-6 flex items-start justify-between hover:shadow-md transition-shadow duration-200">
                    <div class="flex items-start gap-4">
                        @php
                            $notificationType = 'System Notification';
                            $iconColor = 'blue';
                            $iconBgColor = 'blue';
                            
                            if (stripos($notification->message, 'application') !== false) {
                                $notificationType = 'Application';
                                $iconColor = 'green';
                                $iconBgColor = 'green';
                            } elseif (stripos($notification->message, 'message') !== false) {
                                $notificationType = 'Message';
                                $iconColor = 'purple';
                                $iconBgColor = 'purple';
                            } elseif (stripos($notification->message, 'profile') !== false) {
                                $notificationType = 'Profile';
                                $iconColor = 'indigo';
                                $iconBgColor = 'indigo';
                            }
                        @endphp
                        
                        <span class="inline-flex items-center justify-center h-10 w-10 rounded-full bg-{{ $iconBgColor }}-100 dark:bg-{{ $iconBgColor }}-900/30">
                            <svg class="h-6 w-6 text-{{ $iconColor }}-600 dark:text-{{ $iconColor }}-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                @if($notificationType == 'Application')
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                @elseif($notificationType == 'Message')
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                @elseif($notificationType == 'Profile')
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                @else
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                @endif
                            </svg>
                        </span>
                        <div>
                            <div class="flex items-center">
                                <h3 class="text-base font-semibold text-gray-900 dark:text-white">{{ $notification->title }}</h3>
                                <span class="ml-2 px-2 py-0.5 text-xs rounded-full bg-{{ $iconBgColor }}-100 text-{{ $iconColor }}-800 dark:bg-{{ $iconBgColor }}-900/30 dark:text-{{ $iconColor }}-200">{{ $notificationType }}</span>
                            </div>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">{{ $notification->message }}</p>
                            @if(!$notification->is_read)
                            <button data-notification-id="{{ $notification->id }}" class="mark-as-read-btn mt-2 text-xs text-indigo-700 dark:text-indigo-400 hover:underline font-medium">
                                Mark as read
                            </button>
                            @endif
                        </div>
                    </div>
                    <div class="text-xs text-gray-400 dark:text-gray-500 whitespace-nowrap ml-4">{{ $notification->created_at->diffForHumans() }}</div>
                </div>
            @empty
                <div class="rounded-xl shadow bg-white dark:bg-gray-800 p-8 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No notifications</h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">You're all caught up!</p>
                </div>
            @endforelse
        </div>
    </div>

    @push('scripts')
    <script>
        // Handle Mark as Read button click
        document.addEventListener('DOMContentLoaded', function() {
            // Individual mark as read buttons
            const markAsReadButtons = document.querySelectorAll('.mark-as-read-btn');
            markAsReadButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const notificationId = this.getAttribute('data-notification-id');
                    const notificationItem = this.closest('.hover\\:shadow-md');
                    
                    // Immediately update the UI
                    // Remove the background color indicating unread
                    notificationItem.classList.remove('bg-indigo-50');
                    notificationItem.classList.remove('dark:bg-indigo-900/20');
                    // Hide the mark as read button
                    button.style.display = 'none';
                    
                    // Update unread count in the header if it exists
                    const unreadCountElement = document.querySelector('.notification-count');
                    if (unreadCountElement) {
                        const currentCount = parseInt(unreadCountElement.textContent);
                        if (currentCount > 1) {
                            unreadCountElement.textContent = currentCount - 1;
                        } else {
                            unreadCountElement.style.display = 'none';
                        }
                    }
                    
                    // Send AJAX request to mark notification as read in the background
                    $.ajax({
                        url: '/notifications/' + notificationId + '/read',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            _method: 'PUT'
                        },
                        error: function(xhr) {
                            console.error('Error marking notification as read:', xhr.responseText);
                        }
                    });
                });
            });

            // Mark all as read button
            const markAllReadBtn = document.getElementById('mark-all-read-btn');
            if (markAllReadBtn) {
                markAllReadBtn.addEventListener('click', function() {
                    // Immediately update the UI
                    // Remove background color from all unread notifications
                    document.querySelectorAll('.bg-indigo-50, .dark\\:bg-indigo-900\\/20').forEach(item => {
                        item.classList.remove('bg-indigo-50');
                        item.classList.remove('dark:bg-indigo-900/20');
                    });
                    
                    // Hide all mark as read buttons
                    document.querySelectorAll('.mark-as-read-btn').forEach(btn => {
                        btn.style.display = 'none';
                    });
                    
                    // Update unread count in the header if it exists
                    const unreadCountElement = document.querySelector('.notification-count');
                    if (unreadCountElement) {
                        unreadCountElement.style.display = 'none';
                    }
                    
                    // Send AJAX request to mark all notifications as read in the background
                    $.ajax({
                        url: '/notifications/mark-all-read',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            _method: 'PUT'
                        },
                        error: function(xhr) {
                            console.error('Error marking all notifications as read:', xhr.responseText);
                        }
                    });
                });
            }
        });
    </script>
    @endpush
</x-layouts.company>