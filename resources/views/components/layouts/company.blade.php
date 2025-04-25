<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Company Dashboard</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        /* Add custom scrollbar styles if desired */
        ::-webkit-scrollbar { width: 6px; height: 6px;}
        ::-webkit-scrollbar-track { background: rgba(0,0,0,0.1); border-radius: 3px;}
        ::-webkit-scrollbar-thumb { background: rgba(79, 70, 229, 0.6); border-radius: 3px;}
        ::-webkit-scrollbar-thumb:hover { background: rgba(79, 70, 229, 0.8); }
    </style>
</head>
<body class="font-sans antialiased bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-900 dark:to-gray-800 text-gray-900 dark:text-gray-100">
    <div class="flex h-screen overflow-hidden" x-data="{ sidebarOpen: window.innerWidth > 1024 ? true : false }">

        <!-- Sidebar -->
        <x-company.sidebar />

        <!-- Content area -->
        <div class="relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden transition-all duration-300 ease-in-out"
             :class="sidebarOpen ? 'lg:pl-64' : 'lg:pl-20'">

            <!-- Header -->
            <x-company.header />

            <!-- Main content -->
            <main class="flex-1 px-4 py-6 sm:px-6 lg:px-8">
                {{ $slot }}
            </main>

        </div>
    </div>
</body>
</html> 