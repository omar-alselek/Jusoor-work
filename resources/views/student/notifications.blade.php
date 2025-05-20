@extends('layouts.student')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white shadow-md rounded-lg border border-gray-100 overflow-hidden">
        <div class="px-6 py-5">
            <h2 class="text-xl font-bold text-gray-800">Notifications</h2>
            <p class="mt-1 text-sm text-gray-500">Stay updated with application status, messages, and relevant opportunities.</p>
        </div>
    </div>
    
    <div class="bg-white shadow-md rounded-lg border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-medium text-gray-800">All Notifications</h3>
                <button type="button" id="mark-all-read-btn" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Mark all as read
                </button>
            </div>
        </div>
        
        <div class="divide-y divide-gray-100">
            @forelse($notifications as $notification)
                @php
                    $type = $notification->type ?? 'info';
                    $typeClass = 'bg-gray-100 text-gray-800';
                    $typeText = 'System Notification';
                    $icon = 'bell';
                    $title = $notification->title ?? '';
                    if ($type === 'success' || stripos($title, 'approved') !== false) {
                        $typeClass = 'bg-green-100 text-green-800';
                        $typeText = 'Application Approved';
                        $icon = 'check-circle';
                    } elseif ($type === 'error' || stripos($title, 'rejected') !== false) {
                        $typeClass = 'bg-red-100 text-red-800';
                        $typeText = 'Application Rejected';
                        $icon = 'times-circle';
                    } elseif ($type === 'info' && stripos($title, 'message') !== false) {
                        $typeClass = 'bg-blue-100 text-blue-800';
                        $typeText = 'New Message';
                        $icon = 'comment';
                    }
                @endphp
                <div class="flex items-start space-x-4 p-4 border-b border-gray-100">
                    <span class="inline-flex items-center justify-center h-10 w-10 rounded-full {{ $typeClass }}">
                        <i class="fas fa-{{ $icon }} text-lg"></i>
                    </span>
                    <div class="flex-1">
                        <div class="flex items-center justify-between">
                            <h3 class="text-base font-medium text-gray-900">{{ $notification->title }}</h3>
                            <span class="ml-2 px-2 py-0.5 text-xs rounded-full {{ $typeClass }}">{{ $typeText }}</span>
                            <span class="text-xs text-gray-500">{{ $notification->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="mt-1 text-sm text-gray-600">{{ $notification->message }}</p>
                        @if(!$notification->is_read)
                            <button type="button" data-notification-id="{{ $notification->id }}" class="mark-as-read-btn text-xs text-indigo-700 hover:underline font-medium mt-2">Mark as read</button>
                        @endif
                    </div>
                </div>
            @empty
                <div class="p-6 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No notifications</h3>
                    <p class="mt-1 text-sm text-gray-500">You're all caught up!</p>
                </div>
            @endforelse
        </div>
        
        <!-- Simple footer -->
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 text-center">
            <p class="text-sm text-gray-500">{{ count($notifications) }} notifications</p>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Mark individual notification as read
        const markAsReadButtons = document.querySelectorAll('.mark-as-read-btn');
        
        markAsReadButtons.forEach(button => {
            button.addEventListener('click', function() {
                const notificationId = this.getAttribute('data-notification-id');
                const notificationItem = this.closest('.hover\\:bg-gray-50');
                
                // Immediately update the UI
                // Remove the background color indicating unread
                notificationItem.classList.remove('bg-indigo-50');
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
        
        // Mark all notifications as read
        const markAllReadBtn = document.getElementById('mark-all-read-btn');
        if (markAllReadBtn) {
            markAllReadBtn.addEventListener('click', function() {
                // Immediately update the UI
                // Remove background color from all unread notifications
                document.querySelectorAll('.bg-indigo-50').forEach(item => {
                    item.classList.remove('bg-indigo-50');
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
@endsection 