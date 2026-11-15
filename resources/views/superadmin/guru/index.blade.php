@extends('layouts.superadmin')

@section('title', 'Data Guru')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-base-content">Data Guru TPQ Annur</h1>
            <p class="text-sm text-base-content/60 mt-1">Kelola akun guru / ustadz yang mengajar di TPQ</p>
        </div>
        <a href="{{ route('superadmin.guru.create') }}" class="btn btn-primary btn-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
            Tambah Guru Baru
        </a>
    </div>

    <!-- Search Filter Card -->
    <div class="card bg-base-100 shadow-sm border border-base-300">
        <div class="card-body p-4">
            <form method="GET" action="{{ route('superadmin.guru.index') }}" class="flex flex-col sm:flex-row gap-3">
                <div class="flex-1">
                    <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama atau email guru..." class="input input-bordered input-sm w-full" />
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="btn btn-primary btn-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                        Cari
                    </button>
                    @if($search)
                        <a href="{{ route('superadmin.guru.index') }}" class="btn btn-ghost btn-sm">Reset</a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- Guru List -->
    <div class="card bg-base-100 shadow-sm border border-base-300">
        <div class="card-body p-0">
            @if($guruList->isEmpty())
                <div class="text-center py-12 text-base-content/50">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto mb-4 opacity-30" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" /></svg>
                    <p class="text-sm">Belum ada data guru terdaftar.</p>
                    <a href="{{ route('superadmin.guru.create') }}" class="btn btn-primary btn-sm mt-4">Tambah Guru Pertama</a>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="table table-zebra">
                        <thead>
                            <tr class="bg-base-200">
                                <th class="w-12 text-center">#</th>
                                <th>Nama Lengkap</th>
                                <th>Email</th>
                                <th class="text-center">Tanggal Daftar</th>
                                <th class="text-center w-32">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($guruList as $index => $guru)
                                <tr class="hover">
                                    <td class="font-mono text-xs text-base-content/60 text-center">{{ $guruList->firstItem() + $index }}</td>
                                    <td>
                                        <div class="font-semibold text-sm">{{ $guru->name }}</div>
                                        <div class="badge badge-success badge-xs mt-1">Guru</div>
                                    </td>
                                    <td>
                                        <span class="text-xs text-base-content/70">{{ $guru->email }}</span>
                                    </td>
                                    <td class="text-xs text-base-content/70 text-center">
                                        {{ $guru->created_at->format('d M Y') }}
                                    </td>
                                    <td class="text-center">
                                        <div class="flex justify-center gap-1">
                                            <a href="{{ route('superadmin.guru.edit', $guru->id) }}" class="btn btn-ghost btn-xs text-info">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                                Edit
                                            </a>
                                            <form method="POST" action="{{ route('superadmin.guru.destroy', $guru->id) }}" onsubmit="return confirm('Yakin ingin menghapus akun guru {{ $guru->name }}?');" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-ghost btn-xs text-error">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($guruList->hasPages())
                    <div class="p-4 border-t border-base-200">
                        {{ $guruList->links() }}
                    </div>
                @endif
            @endif
        </div>
    </div>
</div>
@endsection
