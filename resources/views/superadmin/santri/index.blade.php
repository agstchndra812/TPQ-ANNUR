@extends('layouts.superadmin')

@section('title', 'Master Data Santri')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-base-content">Data Santri</h1>
            <p class="text-xs text-base-content/60">Kelola informasi santri aktif dan data jilid pengajaran</p>
        </div>
        <a href="{{ route('superadmin.santri.create') }}" class="btn btn-primary bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
            Tambah Santri
        </a>
    </div>

    <!-- Filter Card -->
    <div class="card bg-base-100 shadow-sm border border-base-300">
        <div class="card-body p-4">
            <form method="GET" action="{{ route('superadmin.santri.index') }}" class="flex flex-col sm:flex-row gap-3 items-end">
                <input type="text" name="search" value="{{ $search }}" placeholder="Cari NIS atau Nama..." class="input input-bordered input-sm w-full sm:flex-1 text-xs" />
                
                <select name="jilid" class="select select-bordered select-sm w-full sm:w-auto text-xs">
                    <option value="">-- Semua Jilid / Kelas --</option>
                    @foreach($daftarJilid as $j)
                        <option value="{{ $j }}" {{ $selectedJilid === $j ? 'selected' : '' }}>{{ $j }}</option>
                    @endforeach
                </select>

                <select name="status" class="select select-bordered select-sm w-full sm:w-auto text-xs">
                    <option value="">-- Semua Status --</option>
                    <option value="1" {{ $selectedStatus === '1' ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ $selectedStatus === '0' ? 'selected' : '' }}>Non-Aktif</option>
                </select>

                <div class="flex gap-2 w-full sm:w-auto">
                    <button type="submit" class="btn btn-sm btn-outline btn-primary text-xs flex-1 sm:flex-none">
                        Cari / Filter
                    </button>
                    @if($search || $selectedJilid || $selectedStatus !== null && $selectedStatus !== '')
                        <a href="{{ route('superadmin.santri.index') }}" class="btn btn-sm btn-ghost text-xs" title="Reset filter">
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- Santri Table -->
    <div class="card bg-base-100 shadow-sm border border-base-300">
        <div class="card-body p-0">
            <div class="overflow-x-auto">
                <table class="table table-zebra table-sm">
                    <thead class="bg-base-200 text-base-content/70 text-xs">
                        <tr>
                            <th class="text-center">No</th>
                            <th>NIS</th>
                            <th>Nama Lengkap</th>
                            <th class="text-center">Gender</th>
                            <th class="text-center">Jilid / Kelas</th>
                            <th>Wali Santri</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($santriList as $index => $santri)
                            <tr class="hover">
                                <td class="text-xs text-center">{{ $santriList->firstItem() + $index }}</td>
                                <td class="font-mono font-bold text-xs text-emerald-800">{{ $santri->nis }}</td>
                                <td>
                                    <div class="font-semibold text-xs">{{ $santri->nama_lengkap }}</div>
                                    @if($santri->tempat_lahir || $santri->tanggal_lahir)
                                        <div class="text-[11px] text-base-content/50">
                                            {{ $santri->tempat_lahir ? $santri->tempat_lahir.', ' : '' }}
                                            {{ $santri->tanggal_lahir ? $santri->tanggal_lahir->format('d/m/Y') : '' }}
                                        </div>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($santri->jenis_kelamin === 'L')
                                        <span class="badge badge-xs badge-info text-white">Laki-laki</span>
                                    @else
                                        <span class="badge badge-xs badge-secondary text-white">Perempuan</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <span class="badge badge-sm badge-outline font-semibold">{{ $santri->jilid_kelas }}</span>
                                </td>
                                <td class="text-xs">
                                    @if($santri->orangTua && $santri->orangTua->user)
                                        <div class="font-medium">{{ $santri->orangTua->user->name }}</div>
                                        <div class="text-[11px] text-base-content/50">{{ $santri->orangTua->no_hp ?? '-' }}</div>
                                    @else
                                        <span class="text-base-content/40 italic">Belum terhubung</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($santri->status_aktif)
                                        <span class="badge badge-xs badge-success text-white font-medium">Aktif</span>
                                    @else
                                        <span class="badge badge-xs badge-error text-white font-medium">Non-Aktif</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="flex items-center justify-center gap-1">
                                        <a href="{{ route('superadmin.santri.edit', $santri) }}" class="btn btn-ghost btn-xs text-info" title="Ubah">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                        </a>
                                        <form method="POST" action="{{ route('superadmin.santri.destroy', $santri) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data santri ini? Data presensi dan setoran terkait juga akan terhapus.')" class="inline">
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
                                <td colspan="8" class="text-center py-8 text-base-content/50 text-xs">
                                    Tidak ada data santri ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($santriList->hasPages())
                <div class="p-4 border-t border-base-200">
                    {{ $santriList->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
