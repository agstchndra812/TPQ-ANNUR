<!DOCTYPE html>
<html lang="id" data-theme="emerald">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - Guru TPQ Annur</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Animate.css for smooth animations -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
</head>
<body class="bg-base-200 min-h-screen font-sans text-base-content antialiased">
    <div class="drawer lg:drawer-open">
        <input id="guru-drawer" type="checkbox" class="drawer-toggle" />
        
        <!-- Page Content -->
        <div class="drawer-content flex flex-col min-h-screen">
            <!-- Navbar -->
            <header class="navbar bg-base-100 shadow-sm border-b border-base-300 sticky top-0 z-30 px-4">
                <div class="flex-none lg:hidden">
                    <label for="guru-drawer" aria-label="open sidebar" class="btn btn-square btn-ghost">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-6 h-6 stroke-current"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    </label>
                </div>
                
                <div class="flex-1 px-2">
                    <span class="font-bold text-lg text-emerald-800 hidden sm:inline">Panel Guru TPQ Annur</span>
                    <span class="text-xs text-base-content/60 ml-2 hidden md:inline">| Presensi & Hafalan</span>
                </div>

                <div class="flex-none flex gap-3 items-center">
                    <div class="text-right hidden sm:block">
                        <div class="font-medium text-sm leading-tight">{{ Auth::user()->name }}</div>
                        <div class="badge badge-sm badge-success text-xs font-semibold uppercase mt-0.5">Guru</div>
                    </div>
                    
                    <div class="dropdown dropdown-end">
                        <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar placeholder">
                            <div class="bg-emerald-700 text-neutral-content rounded-full w-10">
                                <span class="text-sm font-bold">{{ strtoupper(substr(Auth::user()->name, 0, 2)) }}</span>
                            </div>
                        </div>
                        <ul tabindex="0" class="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow-lg bg-base-100 rounded-box w-52 border border-base-300">
                            <li class="menu-title px-4 py-2 border-b border-base-200">
                                <span class="font-semibold text-base-content">{{ Auth::user()->name }}</span>
                                <span class="text-xs text-base-content/60">{{ Auth::user()->email }}</span>
                            </li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}" class="w-full">
                                    @csrf
                                    <button type="submit" class="text-error font-medium w-full text-left py-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                                        Keluar (Logout)
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="flex-1 p-4 md:p-6 lg:p-8 max-w-7xl w-full mx-auto">
                @yield('content')
            </main>

            <!-- Footer -->
            <footer class="footer footer-center p-4 bg-base-100 text-base-content/70 border-t border-base-300 text-xs">
                <div>
                    <p>© {{ date('Y') }} TPQ Annur Bogor - Panel Guru</p>
                </div>
            </footer>
        </div>

        <!-- Sidebar / Drawer -->
        <div class="drawer-side z-40">
            <label for="guru-drawer" aria-label="close sidebar" class="drawer-overlay"></label>
            <aside class="bg-base-100 border-r border-base-300 w-72 min-h-screen flex flex-col justify-between">
                <div>
                    <!-- Brand Logo -->
                    <div class="p-6 border-b border-base-200 flex items-center gap-3 bg-emerald-700 text-white">
                        <div class="p-2 bg-white/20 rounded-xl">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                        <div>
                            <h1 class="font-bold text-lg tracking-wide leading-tight">PANEL GURU</h1>
                            <p class="text-xs text-emerald-100 font-light">TPQ Annur Bogor</p>
                        </div>
                    </div>

                    <!-- Navigation Links -->
                    <ul class="menu p-4 gap-1 text-sm font-medium">
                        <li>
                            <a href="{{ route('guru.dashboard') }}" class="{{ request()->routeIs('guru.dashboard') ? 'active bg-emerald-600 text-white font-semibold' : 'hover:bg-base-200' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
                                Dashboard
                            </a>
                        </li>

                        <li class="menu-title mt-4 text-xs font-bold uppercase tracking-wider text-base-content/50">Aktivitas Santri</li>
                        <li>
                            <details {{ request()->routeIs('guru.presensi.*') ? 'open' : '' }}>
                                <summary class="{{ request()->routeIs('guru.presensi.*') ? 'bg-base-200 font-semibold' : '' }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" /></svg>
                                    Presensi Santri
                                </summary>
                                <ul>
                                    <li><a href="{{ route('guru.presensi.index') }}" class="{{ request()->routeIs('guru.presensi.index') ? 'active bg-emerald-600 text-white' : '' }}">Input Presensi Harian</a></li>
                                    <li><a href="{{ route('guru.presensi.rekap') }}" class="{{ request()->routeIs('guru.presensi.rekap') ? 'active bg-emerald-600 text-white' : '' }}">Rekapitulasi Presensi</a></li>
                                </ul>
                            </details>
                        </li>
                        <li>
                            <a href="{{ route('guru.setoran.index') }}" class="{{ request()->routeIs('guru.setoran.*') ? 'active bg-emerald-600 text-white font-semibold' : 'hover:bg-base-200' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                                Setoran Hafalan
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="p-4 border-t border-base-200">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-outline btn-error btn-sm w-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                            Keluar
                        </button>
                    </form>
                </div>
            </aside>
        </div>
    </div>

    <!-- Alert Popup Component -->
    <x-alert-popup />
</body>
</html>
