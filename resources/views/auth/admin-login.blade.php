<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login - Jusoor Work Platform</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <style>
        .admin-login-container {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background-color: #f8fafc;
        }
        .admin-login-card {
            width: 100%;
            max-width: 24rem;
            background: white;
            border-radius: 1rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
        .admin-login-header {
            text-align: center;
            padding: 2rem;
            border-bottom: 1px solid #e5e7eb;
        }
        .admin-login-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #1f2937;
        }
        .admin-login-subtitle {
            margin-top: 0.5rem;
            color: #6b7280;
        }
        .admin-login-form {
            padding: 2rem;
        }
        .form-group {
            margin-bottom: 1.5rem;
        }
        .form-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 500;
            color: #374151;
            margin-bottom: 0.5rem;
        }
        .form-input {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            background-color: white;
        }
        .form-input:focus {
            outline: none;
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        }
        .btn-admin-login {
            width: 100%;
            padding: 0.75rem;
            background: linear-gradient(to right, #6366f1, #8b5cf6);
            color: white;
            font-weight: 500;
            border-radius: 0.375rem;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
        }
        .btn-admin-login:hover {
            background: linear-gradient(to right, #4f46e5, #7c3aed);
        }
        .error-message {
            color: #ef4444;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }
        .security-notice {
            text-align: center;
            padding: 1rem;
            background-color: #fef3c7;
            color: #92400e;
            font-size: 0.875rem;
            border-radius: 0.375rem;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <div class="admin-login-container">
        <div class="admin-login-card">
            <div class="admin-login-header">
                <h1 class="admin-login-title">Admin Login</h1>
                <p class="admin-login-subtitle">Secure access to admin dashboard</p>
            </div>

            @if ($errors->any())
                <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-circle text-red-400"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-red-700">
                                {{ $errors->first() }}
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="security-notice">
                <i class="fas fa-shield-alt mr-2"></i>
                This is a secure admin area. Unauthorized access is prohibited.
            </div>

            <form method="POST" action="{{ route('admin.login.submit') }}" class="admin-login-form">
                @csrf

                <div class="form-group">
                    <label for="email" class="form-label">Admin Email</label>
                    <input id="email" name="email" type="email" class="form-input" value="{{ old('email') }}" required autofocus>
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <input id="password" name="password" type="password" class="form-input" required>
                </div>

                <div class="form-group">
                    <label class="flex items-center">
                        <input type="checkbox" name="remember" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                        <span class="ml-2 text-sm text-gray-600">Remember me</span>
                    </label>
                </div>

                <button type="submit" class="btn-admin-login">
                    <i class="fas fa-lock mr-2"></i> Login
                </button>
            </form>
        </div>
    </div>
</body>
</html> 