@extends('layouts.guru')

@section('title', 'Log Setoran Hafalan')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-base-content">Catatan Setoran Hafalan</h1>
            <p class="text-xs text-base-content/60">Pencatatan hafalan baru (Ziyadah) dan pengulangan hafalan (Muraja'ah)</p>
        </div>
        <a href="{{ route('guru.setoran.create') }}" class="btn btn-primary bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
            Catat Setoran Baru
        </a>
    </div>

    <!-- Filter Card -->
    <div class="card bg-base-100 shadow-sm border border-base-300">
        <div class="card-body p-4">
            <form method="GET" action="{{ route('guru.setoran.index') }}" class="flex flex-col sm:flex-row gap-3 items-end">
                <input type="text" name="search" value="{{ $search }}" placeholder="Cari santri..." class="input input-bordered input-sm w-full sm:flex-1 text-xs" />
                
                <select name="santri_id" class="select select-bordered select-sm w-full sm:w-auto text-xs">
                    <option value="">-- Semua Santri --</option>
                    @foreach($santriList as $s)
                        <option value="{{ $s->id }}" {{ $selectedSantri == $s->id ? 'selected' : '' }}>
                            {{ $s->nama_lengkap }} ({{ $s->jilid_kelas }})
                        </option>
                    @endforeach
                </select>

                <select name="jenis" class="select select-bordered select-sm w-full sm:w-auto text-xs">
                    <option value="">-- Semua Jenis --</option>
                    <option value="ziyadah" {{ $selectedJenis === 'ziyadah' ? 'selected' : '' }}>Ziyadah (Baru)</option>
                    <option value="murajaah" {{ $selectedJenis === 'murajaah' ? 'selected' : '' }}>Muraja'ah (Ulang)</option>
                </select>

                <div class="flex gap-2 w-full sm:w-auto">
                    <button type="submit" class="btn btn-sm btn-outline btn-primary text-xs flex-1 sm:flex-none">
                        Cari / Filter
                    </button>
                    @if($selectedSantri || $selectedJenis || $search)
                        <a href="{{ route('guru.setoran.index') }}" class="btn btn-sm btn-ghost text-xs">Reset</a>
                    @endif
                </div>
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
                            <th class="text-center">Tanggal</th>
                            <th>Nama Santri</th>
                            <th>Surah & Ayat</th>
                            <th class="text-center">Jenis</th>
                            <th class="text-center">Penilaian</th>
                            <th>Catatan</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($setoranList as $index => $setoran)
                            <tr class="hover">
                                <td class="text-xs text-base-content/60 text-center">{{ $setoranList->firstItem() + $index }}</td>
                                <td class="text-xs font-semibold text-center">
                                    {{ $setoran->tanggal_setoran->format('d/m/Y') }}
                                </td>
                                <td>
                                    <div class="font-bold text-xs">{{ $setoran->santri->nama_lengkap }}</div>
                                    <div class="text-[11px] text-base-content/50">{{ $setoran->santri->jilid_kelas }}</div>
                                </td>
                                <td>
                                    <div class="font-semibold text-xs text-emerald-800">
                                        Surah {{ $setoran->surah->nama_surah }}
                                    </div>
                                    <div class="text-[11px] text-base-content/60">
                                        @if($setoran->ayat_mulai && $setoran->ayat_selesai)
                                            Ayat {{ $setoran->ayat_mulai }} - {{ $setoran->ayat_selesai }}
                                        @else
                                            -
                                        @endif
                                    </div>
                                </td>
                                <td class="text-center">
                                    @if($setoran->jenis === 'ziyadah')
                                        <span class="badge badge-xs badge-primary font-medium">Ziyadah</span>
                                    @else
                                        <span class="badge badge-xs badge-neutral font-medium">Muraja'ah</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($setoran->nilai === 'Mumtaz')
                                        <span class="badge badge-xs badge-success text-white font-bold">Mumtaz</span>
                                    @elseif($setoran->nilai === 'Jayyid')
                                        <span class="badge badge-xs badge-info text-white font-bold">Jayyid</span>
                                    @elseif($setoran->nilai === 'Mengulang')
                                        <span class="badge badge-xs badge-warning text-white font-bold">Mengulang</span>
                                    @else
                                        <span class="text-xs text-base-content/50">-</span>
                                    @endif
                                </td>
                                <td class="text-xs text-base-content/70 max-w-xs">
                                    {{ Str::limit($setoran->catatan ?? '-', 50) }}
                                </td>
                                <td>
                                    <div class="flex items-center justify-center gap-1">
                                        <a href="{{ route('guru.setoran.edit', $setoran) }}" class="btn btn-ghost btn-xs text-info" title="Ubah">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                        </a>
                                        <form method="POST" action="{{ route('guru.setoran.destroy', $setoran) }}" onsubmit="return confirm('Hapus riwayat setoran ini?')" class="inline">
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
                            <tr class="hover">
                                <td colspan="8" class="text-center py-8 text-base-content/50 text-xs">
                                    Belum ada data setoran hafalan yang sesuai filter.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($setoranList->hasPages())
                <div class="p-4 border-t border-base-200">
                    {{ $setoranList->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
