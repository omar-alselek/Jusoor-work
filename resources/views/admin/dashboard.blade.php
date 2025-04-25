<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard - Jusoor Work Platform</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gray-100">
    <div class="min-h-screen">
        <!-- Navigation -->
        <nav class="bg-white shadow-lg">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <div class="flex-shrink-0 flex items-center">
                            <span class="text-2xl font-bold text-indigo-600">Jusoor Work</span>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-gray-700 hover:text-indigo-600 px-3 py-2 rounded-md text-sm font-medium">Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white shadow rounded-lg p-6 mb-6">
                <h1 class="text-2xl font-bold text-gray-900 mb-4">Admin Dashboard</h1>
                <p class="text-gray-600">Welcome to the admin dashboard. Here you can manage company applications and users.</p>
            </div>

            <!-- Pending Companies -->
            <div class="bg-white shadow rounded-lg p-6 mb-6">
                <h2 class="text-xl font-semibold mb-4">Pending Companies</h2>
                
                @if($pendingCompanies->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white">
                            <thead>
                                <tr>
                                    <th class="py-3 px-4 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Company</th>
                                    <th class="py-3 px-4 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                    <th class="py-3 px-4 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Field of Work</th>
                                    <th class="py-3 px-4 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Documents</th>
                                    <th class="py-3 px-4 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($pendingCompanies as $company)
                                    <tr>
                                        <td class="py-4 px-4 text-sm font-medium text-gray-900">{{ $company->company_name }}</td>
                                        <td class="py-4 px-4 text-sm text-gray-500">{{ $company->company_email }}</td>
                                        <td class="py-4 px-4 text-sm text-gray-500">{{ $company->field_of_work }}</td>
                                        <td class="py-4 px-4 text-sm text-gray-500">
                                            <div class="space-y-2">
                                                <div class="flex items-center space-x-2">
                                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                                    </svg>
                                                    <a href="{{ Storage::url($company->document_path) }}" 
                                                       target="_blank" 
                                                       class="text-indigo-600 hover:text-indigo-800 flex items-center">
                                                        Main Document
                                                        <svg class="h-4 w-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                                        </svg>
                                                    </a>
                                                </div>
                                                @if($company->additional_documents)
                                                    @foreach($company->additional_documents as $index => $doc)
                                                        <div class="flex items-center space-x-2">
                                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                                            </svg>
                                                            <a href="{{ Storage::url($doc) }}" 
                                                               target="_blank" 
                                                               class="text-indigo-600 hover:text-indigo-800 flex items-center">
                                                                Additional Document {{ $index + 1 }}
                                                                <svg class="h-4 w-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                                                </svg>
                                                            </a>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </td>
                                        <td class="py-4 px-4 text-sm font-medium">
                                            <div class="flex space-x-2">
                                                <form action="{{ route('admin.companies.approve', $company) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700">
                                                        Approve
                                                    </button>
                                                </form>
                                                
                                                <button type="button" 
                                                    class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700"
                                                    onclick="document.getElementById('rejection-form-{{ $company->id }}').classList.toggle('hidden')">
                                                    Reject
                                                </button>
                                            </div>
                                            
                                            <div id="rejection-form-{{ $company->id }}" class="hidden mt-3 p-3 bg-gray-50 rounded">
                                                <form action="{{ route('admin.companies.reject', $company) }}" method="POST">
                                                    @csrf
                                                    <div class="mb-3">
                                                        <label for="rejection_reason" class="block text-sm font-medium text-gray-700">Rejection Reason</label>
                                                        <textarea 
                                                            name="rejection_reason" 
                                                            id="rejection_reason" 
                                                            rows="3" 
                                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                                            required
                                                        ></textarea>
                                                    </div>
                                                    <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">Confirm Rejection</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-gray-500">No pending companies at the moment.</p>
                @endif
            </div>

            <!-- Users Management -->
            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-xl font-semibold mb-4">User Management</h2>
                
                @if($users->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white">
                            <thead>
                                <tr>
                                    <th class="py-3 px-4 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                    <th class="py-3 px-4 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                    <th class="py-3 px-4 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                                    <th class="py-3 px-4 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="py-3 px-4 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($users as $user)
                                    <tr>
                                        <td class="py-4 px-4 text-sm font-medium text-gray-900">{{ $user->name }}</td>
                                        <td class="py-4 px-4 text-sm text-gray-500">{{ $user->email }}</td>
                                        <td class="py-4 px-4 text-sm text-gray-500">
                                            @if($user->role === 'company')
                                                Company
                                            @elseif($user->role === 'student')
                                                Student
                                            @elseif($user->role === 'job_seeker')
                                                Job Seeker
                                            @else
                                                {{ ucfirst($user->role) }}
                                            @endif
                                        </td>
                                        <td class="py-4 px-4 text-sm text-gray-500">
                                            @if($user->is_blocked)
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                    Blocked
                                                </span>
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    Active
                                                </span>
                                            @endif
                                        </td>
                                        <td class="py-4 px-4 text-sm font-medium">
                                            <div class="flex space-x-2">
                                                @if($user->is_blocked)
                                                    <form action="{{ route('admin.users.unblock', $user) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700">
                                                            Unblock
                                                        </button>
                                                    </form>
                                                @else
                                                    <form action="{{ route('admin.users.block', $user) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="bg-yellow-600 text-white px-3 py-1 rounded hover:bg-yellow-700">
                                                            Block
                                                        </button>
                                                    </form>
                                                @endif
                                                
                                                <form action="{{ route('admin.users.delete', $user) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-gray-500">No users found.</p>
                @endif
            </div>
        </main>
    </div>
</body>
</html> 