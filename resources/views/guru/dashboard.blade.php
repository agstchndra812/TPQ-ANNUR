@extends('layouts.guru')

@section('title', 'Dashboard Guru')

@section('content')
<div class="space-y-6">
    <!-- Welcome Banner -->
    <div class="bg-gradient-to-r from-emerald-800 to-teal-700 rounded-2xl p-6 text-white shadow-lg flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
        <div>
            <span class="badge badge-sm bg-white/20 text-white border-none font-medium mb-2">{{ date('l, d F Y') }}</span>
            <h1 class="text-2xl font-black tracking-tight">Assalamualaikum, Ustadz/ah {{ Auth::user()->name }}</h1>
            <p class="text-emerald-100 text-sm mt-1">Sistem Input Presensi dan Setoran Hafalan Santri TPQ Annur Bogor</p>
        </div>
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('guru.presensi.index') }}" class="btn btn-sm bg-white text-emerald-800 hover:bg-emerald-50 border-none font-bold shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" /></svg>
                Input Presensi
            </a>
            <a href="{{ route('guru.setoran.create') }}" class="btn btn-sm bg-emerald-600 hover:bg-emerald-500 text-white border-none font-bold shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                Catat Setoran
            </a>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Stat: Total Santri Aktif -->
        <div class="card bg-base-100 shadow-sm border border-base-300">
            <div class="card-body p-5">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold text-base-content/60 uppercase tracking-wider">Santri Aktif</span>
                    <div class="p-2 rounded-xl bg-emerald-100 text-emerald-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                    </div>
                </div>
                <div class="text-3xl font-black mt-2 text-base-content">{{ $stats['total_santri'] }}</div>
                <div class="text-xs text-base-content/60 mt-1">
                    <span>Total santri aktif TPQ</span>
                </div>
            </div>
        </div>

        <!-- Stat: Presensi Hari Ini -->
        <div class="card bg-base-100 shadow-sm border border-base-300">
            <div class="card-body p-5">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold text-base-content/60 uppercase tracking-wider">Presensi Hari Ini</span>
                    <div class="p-2 rounded-xl bg-blue-100 text-blue-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                </div>
                <div class="text-3xl font-black mt-2 text-emerald-600">{{ $stats['presensi_hari_ini'] }}</div>
                <div class="text-xs text-base-content/60 mt-1">
                    <span>Santri yang sudah diabsen</span>
                </div>
            </div>
        </div>

        <!-- Stat: Setoran Hari Ini -->
        <div class="card bg-base-100 shadow-sm border border-base-300">
            <div class="card-body p-5">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold text-base-content/60 uppercase tracking-wider">Setoran Hari Ini</span>
                    <div class="p-2 rounded-xl bg-amber-100 text-amber-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                    </div>
                </div>
                <div class="text-3xl font-black mt-2 text-base-content">{{ $stats['setoran_hari_ini'] }}</div>
                <div class="text-xs text-base-content/60 mt-1">
                    <span>Hafalan yang disetorkan</span>
                </div>
            </div>
        </div>

        <!-- Stat: Presensi Bulan Ini -->
        <div class="card bg-base-100 shadow-sm border border-base-300">
            <div class="card-body p-5">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold text-base-content/60 uppercase tracking-wider">Presensi Bulan Ini</span>
                    <div class="p-2 rounded-xl bg-purple-100 text-purple-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                    </div>
                </div>
                <div class="text-3xl font-black mt-2 text-base-content">{{ $stats['presensi_bulan_ini'] }}</div>
                <div class="text-xs text-base-content/60 mt-1">
                    <span>Total presensi bulan {{ date('F') }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <!-- Presensi Card -->
        <div class="card bg-gradient-to-br from-blue-50 to-cyan-50 border border-blue-200 shadow-sm">
            <div class="card-body p-6">
                <h3 class="text-lg font-bold flex items-center gap-2 text-blue-900">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" /></svg>
                    Presensi Santri
                </h3>
                <p class="text-sm text-base-content/70 mt-2">Input dan kelola kehadiran santri setiap hari</p>
                <div class="card-actions justify-end mt-4">
                    <a href="{{ route('guru.presensi.index') }}" class="btn btn-primary btn-sm">Input Presensi</a>
                    <a href="{{ route('guru.presensi.rekap') }}" class="btn btn-outline btn-sm">Lihat Rekap</a>
                </div>
            </div>
        </div>

        <!-- Setoran Card -->
        <div class="card bg-gradient-to-br from-amber-50 to-orange-50 border border-amber-200 shadow-sm">
            <div class="card-body p-6">
                <h3 class="text-lg font-bold flex items-center gap-2 text-amber-900">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                    Setoran Hafalan
                </h3>
                <p class="text-sm text-base-content/70 mt-2">Catat hafalan ziyadah dan muraja'ah santri</p>
                <div class="card-actions justify-end mt-4">
                    <a href="{{ route('guru.setoran.create') }}" class="btn btn-primary btn-sm">Catat Setoran</a>
                    <a href="{{ route('guru.setoran.index') }}" class="btn btn-outline btn-sm">Daftar Setoran</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Info Panel -->
    <div class="alert alert-info">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-current shrink-0 w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        <div class="text-sm">
            <h3 class="font-bold">Informasi Guru</h3>
            <div class="text-xs">Anda dapat mengelola presensi dan setoran hafalan santri. Untuk mengelola data master, silakan hubungi SuperAdmin.</div>
        </div>
    </div>
</div>
@endsection
