@extends('layouts.app')

@section('content')
<div class="flex flex-col items-center justify-center min-h-[60vh]">
    <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-6 rounded shadow-md max-w-lg w-full">
        <div class="flex items-center mb-4">
            <svg class="h-8 w-8 text-yellow-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M12 20a8 8 0 100-16 8 8 0 000 16z" />
            </svg>
            <h2 class="text-xl font-bold">Waiting for Admin Approval</h2>
        </div>
        <p class="text-gray-700 mb-2">Your company profile is under review. You cannot access the dashboard or any features until an admin approves your account.</p>
        <p class="text-gray-600 text-sm">We will notify you by email once your company is approved. Thank you for your patience!</p>
    </div>
</div>
@endsection 