<!DOCTYPE html>
<html lang="id" data-theme="emerald">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Portal Wali Santri') - TPQ Annur Bogor</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Animate.css for smooth animations -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
</head>
<body class="bg-base-200 min-h-screen font-sans text-base-content antialiased flex flex-col">
    <!-- Top Header -->
    <header class="bg-gradient-to-r from-emerald-800 to-teal-700 text-white shadow-md sticky top-0 z-30">
        <div class="max-w-4xl mx-auto px-4 py-3 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-white/20 rounded-xl backdrop-blur-xs">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
                <div>
                    <h1 class="font-bold text-base md:text-lg leading-tight">TPQ Annur Bogor</h1>
                    <p class="text-xs text-emerald-100">Portal Monitoring Wali Santri</p>
                </div>
            </div>

            <div class="flex items-center gap-2">
                <span class="text-xs hidden sm:inline text-emerald-100">{{ Auth::user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-xs btn-outline border-white/40 text-white hover:bg-white hover:text-emerald-800" title="Keluar">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                        <span class="hidden sm:inline ml-1">Keluar</span>
                    </button>
                </form>
            </div>
        </div>
    </header>

    <!-- Main Container -->
    <main class="flex-1 max-w-4xl w-full mx-auto p-4 sm:p-6 pb-16">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer footer-center p-4 bg-base-100 text-base-content/60 border-t border-base-300 text-xs">
        <div>
            <p>© {{ date('Y') }} TPQ Annur Bogor - Layanan Informasi & Monitoring Santri</p>
        </div>
    </footer>

    <!-- Alert Popup Component -->
    <x-alert-popup />
</body>
</html>

