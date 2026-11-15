@extends('layouts.guru')

@section('title', 'Input Presensi Harian Santri')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-base-content">Input Presensi Harian Santri</h1>
            <p class="text-xs text-base-content/60">Pencatatan presensi massal seluruh santri per tanggal kehadiran</p>
        </div>
        <a href="{{ route('guru.presensi.rekap') }}" class="btn btn-outline btn-sm text-xs">
            📊 Lihat Rekapitulasi Presensi
        </a>
    </div>

    <!-- Date & Filter Selector Bar -->
    <div class="card bg-base-100 shadow-sm border border-base-300">
        <div class="card-body p-4">
            <form method="GET" action="{{ route('guru.presensi.index') }}" class="flex flex-col sm:flex-row gap-3 items-end">
                <input type="date" name="tanggal" value="{{ $tanggal }}" class="input input-bordered input-sm w-full sm:w-auto text-xs" />
                
                <select name="jilid" class="select select-bordered select-sm w-full sm:w-auto text-xs">
                    <option value="">-- Semua Jilid / Kelas --</option>
                    @foreach($daftarJilid as $j)
                        <option value="{{ $j }}" {{ $selectedJilid === $j ? 'selected' : '' }}>{{ $j }}</option>
                    @endforeach
                </select>

                <div class="flex gap-2 w-full sm:w-auto">
                    <button type="submit" class="btn btn-sm btn-outline btn-primary text-xs flex-1 sm:flex-none">
                        Cari / Filter
                    </button>
                    @if($selectedJilid || $tanggal !== date('Y-m-d'))
                        <a href="{{ route('guru.presensi.index') }}" class="btn btn-sm btn-ghost text-xs">Reset</a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <div class="flex items-center gap-2 justify-end">
        <button type="button" onclick="setSemuaStatus('Hadir')" class="btn btn-xs btn-outline btn-success font-medium">
            ✓ Set Semua Hadir
        </button>
        <button type="button" onclick="setSemuaStatus('Izin')" class="btn btn-xs btn-outline btn-info font-medium">
            Set Semua Izin
        </button>
    </div>

    <!-- Bulk Form Table -->
    <form method="POST" action="{{ route('guru.presensi.store') }}">
        @csrf
        <input type="hidden" name="tanggal" value="{{ $tanggal }}" />

        <div class="card bg-base-100 shadow-sm border border-base-300">
            <div class="card-body p-0">
                <div class="overflow-x-auto">
                    <table class="table table-sm">
                        <thead class="bg-base-200 text-base-content/70 text-xs">
                            <tr>
                                <th class="w-12 text-center">No</th>
                                <th>NIS</th>
                                <th>Nama Santri</th>
                                <th>Jilid</th>
                                <th class="text-center w-64">Status Kehadiran</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($santriList as $index => $santri)
                                @php
                                    $presensi = $existingPresensi->get($santri->id);
                                    $currentStatus = $presensi ? $presensi->status : 'Hadir';
                                @endphp
                                <tr class="hover">
                                    <td class="text-center text-xs text-base-content/60">{{ $index + 1 }}</td>
                                    <td class="font-mono text-xs font-bold text-emerald-800">{{ $santri->nis }}</td>
                                    <td>
                                        <div class="font-bold text-xs">{{ $santri->nama_lengkap }}</div>
                                    </td>
                                    <td>
                                        <span class="badge badge-xs badge-ghost font-medium">{{ $santri->jilid_kelas }}</span>
                                    </td>
                                    <td class="text-center">
                                        <input type="hidden" name="presensi[{{ $loop->index }}][santri_id]" value="{{ $santri->id }}" />
                                        <div class="join">
                                            <input class="join-item btn btn-xs status-radio {{ $currentStatus === 'Hadir' ? 'btn-success text-white' : 'btn-outline' }}"
                                                   type="radio"
                                                   name="presensi[{{ $loop->index }}][status]"
                                                   value="Hadir"
                                                   aria-label="Hadir"
                                                   {{ $currentStatus === 'Hadir' ? 'checked' : '' }} />
                                            <input class="join-item btn btn-xs status-radio {{ $currentStatus === 'Izin' ? 'btn-info text-white' : 'btn-outline' }}"
                                                   type="radio"
                                                   name="presensi[{{ $loop->index }}][status]"
                                                   value="Izin"
                                                   aria-label="Izin"
                                                   {{ $currentStatus === 'Izin' ? 'checked' : '' }} />
                                            <input class="join-item btn btn-xs status-radio {{ $currentStatus === 'Sakit' ? 'btn-warning text-white' : 'btn-outline' }}"
                                                   type="radio"
                                                   name="presensi[{{ $loop->index }}][status]"
                                                   value="Sakit"
                                                   aria-label="Sakit"
                                                   {{ $currentStatus === 'Sakit' ? 'checked' : '' }} />
                                            <input class="join-item btn btn-xs status-radio {{ $currentStatus === 'Alpa' ? 'btn-error text-white' : 'btn-outline' }}"
                                                   type="radio"
                                                   name="presensi[{{ $loop->index }}][status]"
                                                   value="Alpa"
                                                   aria-label="Alpa"
                                                   {{ $currentStatus === 'Alpa' ? 'checked' : '' }} />
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-8 text-base-content/50 text-xs">
                                        Tidak ada data santri aktif untuk dipresensi.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($santriList->isNotEmpty())
                    <div class="p-4 bg-base-100 border-t border-base-200 flex justify-between items-center">
                        <span class="text-xs text-base-content/60">
                            Total: <b>{{ $santriList->count() }}</b> santri aktif
                        </span>
                        <button type="submit" class="btn btn-primary bg-emerald-600 hover:bg-emerald-700 text-white font-bold btn-sm text-xs shadow-md">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                            Simpan Presensi Tanggal {{ \Carbon\Carbon::parse($tanggal)->format('d/m/Y') }}
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </form>
</div>

<script>
    function setSemuaStatus(targetStatus) {
        document.querySelectorAll('input[type="radio"][value="' + targetStatus + '"]').forEach(radio => {
            radio.checked = true;
        });
    }
</script>
@endsection
