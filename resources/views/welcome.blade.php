<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Jusoor Work Platform</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
</head>
<body class="bg-gradient-to-br from-gray-50 to-gray-100 dark:bg-[#0a0a0a] text-[#1b1b18]">
    <div class="min-h-screen">
        <!-- Navigation -->
        <nav class="bg-white/80 backdrop-blur-md shadow-sm fixed w-full z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <span class="text-2xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">Jusoor Work</span>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        @guest
                            <a href="{{ route('login') }}" class="text-gray-600 hover:text-indigo-600 px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200">Login</a>
                            <a href="{{ route('register') }}" class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-6 py-2 rounded-lg text-sm font-medium hover:from-indigo-700 hover:to-purple-700 transition-all duration-200 shadow-md hover:shadow-lg">Register</a>
                        @else
                            <a href="{{ route('admin.dashboard') }}" class="text-gray-600 hover:text-indigo-600 px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200">Dashboard</a>
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit" class="text-gray-600 hover:text-indigo-600 px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200">
                                    <i class="fas fa-sign-out-alt mr-1"></i>Logout
                                </button>
                            </form>
                        @endguest
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <div class="relative pt-24 pb-16 sm:pt-32 sm:pb-24 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1522071820081-009f0129c71c?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=MnwxMTc3M3wwfDF8c2VhcmNofDQyfHxzdHVkZW50cyUyMGNvbGxhYm9yYXRpb258ZW58MHx8fHwxNjE3NzMwNjcw&ixlib=rb-1.2.1&q=80&w=1920')">
            <div class="absolute inset-0 bg-black/50 backdrop-blur-sm"></div> 
            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h1 class="text-4xl tracking-tight font-extrabold text-white sm:text-5xl md:text-6xl">
                        <span class="block">Connect Syrian Students and</span>
                        <span class="block bg-gradient-to-r from-indigo-400 to-purple-400 bg-clip-text text-transparent mt-2">Graduates with Opportunities</span>
                    </h1>
                    <p class="mt-6 max-w-2xl mx-auto text-xl text-gray-200">
                        Your dedicated platform for internships, part-time jobs, and full-time careers in Syria and beyond.
                    </p>
                    <div class="mt-10 flex flex-col sm:flex-row justify-center items-center space-y-4 sm:space-y-0 sm:space-x-4">
                        <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-lg text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-1 w-full sm:w-auto">
                            Get Started
                            <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                        <a href="#features" class="inline-flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-lg text-indigo-700 bg-indigo-100 hover:bg-indigo-200 transition-colors duration-200 w-full sm:w-auto">
                            Learn More
                            <i class="fas fa-info-circle ml-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Features Section -->
        <div id="features" class="py-16 bg-white/70 backdrop-blur-md">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h2 class="text-base text-indigo-600 font-semibold tracking-wide uppercase">Why Jusoor Work?</h2>
                    <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                        Empowering Syrian Talent
                    </p>
                </div>

                <div class="mt-16 grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                    <!-- Tailored Opportunities Card -->
                    <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow duration-300 transform hover:-translate-y-1">
                        <div class="flex items-center justify-center h-12 w-12 rounded-lg bg-gradient-to-r from-indigo-500 to-purple-500 text-white mb-4 shadow-md">
                            <i class="fas fa-briefcase text-xl"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Tailored Opportunities</h3>
                        <p class="text-gray-500 text-sm">
                            Find internships, part-time, and full-time roles specifically curated for Syrian students and graduates.
                        </p>
                    </div>

                    <!-- Company Connections Card -->
                    <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow duration-300 transform hover:-translate-y-1">
                        <div class="flex items-center justify-center h-12 w-12 rounded-lg bg-gradient-to-r from-indigo-500 to-purple-500 text-white mb-4 shadow-md">
                            <i class="fas fa-building text-xl"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Direct Company Access</h3>
                        <p class="text-gray-500 text-sm">
                            Companies can easily post listings, manage applications, and connect directly with promising talent.
                        </p>
                    </div>

                    <!-- Career Growth Card -->
                    <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow duration-300 transform hover:-translate-y-1">
                        <div class="flex items-center justify-center h-12 w-12 rounded-lg bg-gradient-to-r from-indigo-500 to-purple-500 text-white mb-4 shadow-md">
                            <i class="fas fa-chart-line text-xl"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Career Development</h3>
                        <p class="text-gray-500 text-sm">
                            Access resources and guidance to help you build your professional network and achieve career goals.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- How It Works Section -->
        <div id="how-it-works" class="py-16 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-base text-indigo-600 font-semibold tracking-wide uppercase">Simple Steps</h2>
                    <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                        Get Started Easily
                    </p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
                    <div class="flex flex-col items-center">
                        <div class="flex items-center justify-center h-16 w-16 rounded-full bg-indigo-100 text-indigo-600 mb-4 text-2xl">
                           <i class="fas fa-user-plus"></i>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">1. Register</h3>
                        <p class="text-gray-500 text-sm">Create your account as a student, company, or job seeker in minutes.</p>
                    </div>
                     <div class="flex flex-col items-center">
                        <div class="flex items-center justify-center h-16 w-16 rounded-full bg-indigo-100 text-indigo-600 mb-4 text-2xl">
                           <i class="fas fa-search"></i>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">2. Explore / Post</h3>
                        <p class="text-gray-500 text-sm">Browse job listings or post your opportunities to attract talent.</p>
                    </div>
                     <div class="flex flex-col items-center">
                        <div class="flex items-center justify-center h-16 w-16 rounded-full bg-indigo-100 text-indigo-600 mb-4 text-2xl">
                           <i class="fas fa-handshake"></i>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">3. Connect</h3>
                        <p class="text-gray-500 text-sm">Apply for jobs or review applications and start making connections.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="bg-gray-800 py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center text-gray-400 text-sm">
                    <p>&copy; {{ date('Y') }} Jusoor Work Platform. All rights reserved.</p>
                    {{-- Optional: Add more footer links here --}}
                </div>
            </div>
        </footer>
    </div>
</body>
</html>
