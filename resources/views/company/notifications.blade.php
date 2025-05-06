@extends('layouts.app')

@section('content')
<div class="flex min-h-screen">
    <!-- Sidebar -->
    <x-company.sidebar />
    <div class="flex-1 flex flex-col min-h-screen bg-gradient-to-br from-gray-100 to-gray-200">
        <!-- Main Content -->
        <div class="flex-1 flex flex-col items-center py-10">
            <div class="w-full max-w-3xl">
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900">Notifications</h2>
                    <p class="text-gray-500 mt-1">Stay updated with applications, messages, and system updates.</p>
                </div>
                <div class="space-y-6">
                    @php
                        $notifications = Auth::user()->notifications()->orderBy('created_at', 'desc')->get();
                    @endphp
                    @forelse($notifications as $notification)
                        <div class="rounded-xl shadow bg-white {{ !$notification->is_read ? 'border-l-4 border-indigo-500 bg-indigo-50' : '' }} p-6 flex items-start justify-between">
                            <div class="flex items-start gap-4">
                                <span class="inline-flex items-center justify-center h-10 w-10 rounded-full bg-blue-100">
                                    <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                    </svg>
                                </span>
                                <div>
                                    <h3 class="text-base font-semibold text-gray-900">{{ $notification->title }}</h3>
                                    <p class="mt-1 text-sm text-gray-600">{{ $notification->message }}</p>
                                    @if(!$notification->is_read)
                                    <form method="POST" action="{{ route('notifications.markAsRead', $notification->id) }}" class="mt-2">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="text-xs text-indigo-700 hover:underline font-medium">Mark as read</button>
                                    </form>
                                    @endif
                                </div>
                            </div>
                            <div class="text-xs text-gray-400 whitespace-nowrap ml-4">{{ $notification->created_at->diffForHumans() }}</div>
                        </div>
                    @empty
                        <div class="rounded-xl shadow bg-white p-8 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No notifications</h3>
                            <p class="mt-1 text-sm text-gray-500">You're all caught up!</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 