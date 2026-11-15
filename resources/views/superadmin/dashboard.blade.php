@extends('layouts.superadmin')

@section('title', 'Dashboard SuperAdmin')

@section('content')
<div class="space-y-6">
    <!-- Welcome Banner -->
    <div class="bg-gradient-to-r from-emerald-800 to-teal-700 rounded-2xl p-6 text-white shadow-lg flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
        <div>
            <span class="badge badge-sm bg-white/20 text-white border-none font-medium mb-2">{{ date('l, d F Y') }}</span>
            <h1 class="text-2xl font-black tracking-tight">Dashboard SuperAdmin - {{ Auth::user()->name }}</h1>
            <p class="text-emerald-100 text-sm mt-1">Kelola semua master data TPQ Annur Bogor</p>
        </div>
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('superadmin.santri.create') }}" class="btn btn-sm bg-white text-emerald-800 hover:bg-emerald-50 border-none font-bold shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                Tambah Santri
            </a>
            <a href="{{ route('superadmin.guru.create') }}" class="btn btn-sm bg-emerald-600 hover:bg-emerald-500 text-white border-none font-bold shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                Tambah Guru
            </a>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Stat: Total Santri -->
        <div class="card bg-base-100 shadow-sm border border-base-300">
            <div class="card-body p-5">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold text-base-content/60 uppercase tracking-wider">Total Santri</span>
                    <div class="p-2 rounded-xl bg-emerald-100 text-emerald-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                    </div>
                </div>
                <div class="text-3xl font-black mt-2 text-base-content">{{ $stats['total_santri'] }}</div>
                <div class="text-xs text-base-content/60 mt-1">
                    <span>Santri Aktif: <b>{{ $stats['santri_aktif'] }}</b></span>
                </div>
            </div>
        </div>

        <!-- Stat: Total Guru -->
        <div class="card bg-base-100 shadow-sm border border-base-300">
            <div class="card-body p-5">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold text-base-content/60 uppercase tracking-wider">Total Guru</span>
                    <div class="p-2 rounded-xl bg-emerald-100 text-emerald-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                    </div>
                </div>
                <div class="text-3xl font-black mt-2 text-base-content">{{ $stats['total_guru'] }}</div>
                <div class="text-xs text-base-content/60 mt-1">
                    <span>Akun guru terdaftar</span>
                </div>
            </div>
        </div>

        <!-- Stat: Orang Tua -->
        <div class="card bg-base-100 shadow-sm border border-base-300">
            <div class="card-body p-5">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold text-base-content/60 uppercase tracking-wider">Orang Tua</span>
                    <div class="p-2 rounded-xl bg-blue-100 text-blue-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                    </div>
                </div>
                <div class="text-3xl font-black mt-2 text-base-content">{{ $stats['total_orang_tua'] }}</div>
                <div class="text-xs text-base-content/60 mt-1">
                    <span>Akun wali santri</span>
                </div>
            </div>
        </div>

        <!-- Stat: Total User -->
        <div class="card bg-base-100 shadow-sm border border-base-300">
            <div class="card-body p-5">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold text-base-content/60 uppercase tracking-wider">Total User</span>
                    <div class="p-2 rounded-xl bg-amber-100 text-amber-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                    </div>
                </div>
                <div class="text-3xl font-black mt-2 text-base-content">{{ $stats['total_guru'] + $stats['total_orang_tua'] + 1 }}</div>
                <div class="text-xs text-base-content/60 mt-1">
                    <span>Seluruh pengguna sistem</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="card bg-base-100 shadow-sm border border-base-300">
        <div class="card-body p-6">
            <h2 class="card-title text-base font-bold mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                Aksi Cepat
            </h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                <a href="{{ route('superadmin.guru.index') }}" class="btn btn-outline btn-sm hover:bg-purple-50">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                    Kelola Guru
                </a>
                <a href="{{ route('superadmin.santri.index') }}" class="btn btn-outline btn-sm hover:bg-emerald-50">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                    Kelola Santri
                </a>
                <a href="{{ route('superadmin.orang_tua.index') }}" class="btn btn-outline btn-sm hover:bg-blue-50">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                    Kelola Orang Tua
                </a>
                <a href="{{ route('superadmin.surah.index') }}" class="btn btn-outline btn-sm hover:bg-amber-50">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                    Data Surah
                </a>
            </div>
        </div>
    </div>

    <!-- Info Panel -->
    <div class="alert alert-info">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-current shrink-0 w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        <div class="text-sm">
            <h3 class="font-bold">Informasi SuperAdmin</h3>
            <div class="text-xs">Anda memiliki akses penuh untuk mengelola semua master data. Guru hanya dapat mengakses presensi dan setoran hafalan.</div>
        </div>
    </div>
</div>
@endsection
