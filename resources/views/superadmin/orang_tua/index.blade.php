@extends('layouts.superadmin')

@section('title', 'Master Data Wali Santri')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-base-content">Data Wali Santri</h1>
            <p class="text-xs text-base-content/60">Kelola akun dan profil orang tua yang dapat memantau santri secara mandiri</p>
        </div>
        <a href="{{ route('superadmin.orang_tua.create') }}" class="btn btn-primary bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
            Tambah Wali Santri
        </a>
    </div>

    <!-- Filter Card -->
    <div class="card bg-base-100 shadow-sm border border-base-300">
        <div class="card-body p-4">
            <form method="GET" action="{{ route('superadmin.orang_tua.index') }}" class="flex flex-col sm:flex-row gap-3">
                <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama orang tua, email, atau no. HP..." class="input input-bordered input-sm w-full text-xs" />
                <button type="submit" class="btn btn-sm btn-outline btn-primary text-xs shrink-0">
                    Cari Data
                </button>
                @if($search)
                    <a href="{{ route('superadmin.orang_tua.index') }}" class="btn btn-sm btn-ghost text-xs shrink-0">Reset</a>
                @endif
            </form>
        </div>
    </div>

    <!-- Table -->
    <div class="card bg-base-100 shadow-sm border border-base-300">
        <div class="card-body p-0">
            <div class="overflow-x-auto">
                <table class="table table-zebra table-sm">
                    <thead class="bg-base-200 text-base-content/70 text-xs">
                        <tr>
                            <th class="text-center">No</th>
                            <th>Nama Wali Santri</th>
                            <th>Email Login</th>
                            <th class="text-center">Nomor HP</th>
                            <th>Alamat</th>
                            <th class="text-center">Santri Terhubung</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orangTuaList as $index => $ot)
                            <tr class="hover">
                                <td class="text-xs text-center">{{ $orangTuaList->firstItem() + $index }}</td>
                                <td>
                                    <div class="font-bold text-xs">{{ $ot->user->name ?? '-' }}</div>
                                </td>
                                <td class="text-xs font-mono text-base-content/70">
                                    {{ $ot->user->email ?? '-' }}
                                </td>
                                <td class="text-xs text-center">
                                    {{ $ot->no_hp ?? '-' }}
                                </td>
                                <td class="text-xs text-base-content/70 max-w-xs truncate">
                                    {{ $ot->alamat ?? '-' }}
                                </td>
                                <td class="text-center">
                                    @if($ot->santri->isNotEmpty())
                                        <div class="flex flex-wrap gap-1">
                                            @foreach($ot->santri as $s)
                                                <span class="badge badge-xs badge-success text-white">
                                                    {{ $s->nama_lengkap }} ({{ $s->jilid_kelas }})
                                                </span>
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="text-[11px] text-base-content/40 italic">Belum ada santri terhubung</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="flex items-center justify-center gap-1">
                                        <a href="{{ route('superadmin.orang_tua.edit', $ot) }}" class="btn btn-ghost btn-xs text-info" title="Ubah">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                        </a>
                                        <form method="POST" action="{{ route('superadmin.orang_tua.destroy', $ot) }}" onsubmit="return confirm('Hapus data orang tua ini beserta akun loginnya?')" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-ghost btn-xs text-error" title="Hapus">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-8 text-base-content/50 text-xs">
                                    Belum ada data orang tua terdaftar.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($orangTuaList->hasPages())
                <div class="p-4 border-t border-base-200">
                    {{ $orangTuaList->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
