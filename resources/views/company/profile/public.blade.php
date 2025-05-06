@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-10">
    <div class="bg-white shadow-lg rounded-xl p-8 border border-gray-200">
        <div class="flex flex-col md:flex-row md:items-center md:space-x-8">
            <div class="flex-shrink-0 flex justify-center md:block mb-6 md:mb-0">
                @if($company->logo_path)
                    <img src="{{ Storage::url($company->logo_path) }}" alt="{{ $company->company_name }} Logo" class="w-32 h-32 rounded-full object-cover border-4 border-indigo-100 shadow">
                @else
                    <div class="w-32 h-32 rounded-full bg-gray-200 flex items-center justify-center">
                        <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                @endif
            </div>
            <div class="flex-1">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $company->company_name }}</h1>
                <p class="text-gray-600 mb-4">{{ $company->field_of_work }}</p>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-700 mb-4">
                    <div><span class="font-medium">Company Size:</span> {{ ucfirst($company->company_size) }}</div>
                    <div><span class="font-medium">Location:</span> {{ $company->location }}</div>
                    <div><span class="font-medium">Email:</span> <a href="mailto:{{ $company->company_email }}" class="text-indigo-600 hover:underline">{{ $company->company_email }}</a></div>
                    @if($company->website)
                    <div><span class="font-medium">Website:</span> <a href="{{ $company->website }}" target="_blank" class="text-indigo-600 hover:underline">{{ $company->website }}</a></div>
                    @endif
                </div>
                <div class="mt-4">
                    <h2 class="text-lg font-semibold text-gray-800 mb-2">About the Company</h2>
                    <p class="text-gray-700">{{ $company->description ?? 'No description available.' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 