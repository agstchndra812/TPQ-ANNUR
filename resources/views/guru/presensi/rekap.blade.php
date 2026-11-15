@extends('layouts.guru')

@section('title', 'Rekapitulasi Presensi Santri')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-base-content">Rekapitulasi Presensi Santri</h1>
            <p class="text-xs text-base-content/60">Ringkasan kehadiran santri per bulan dan jilid kelas</p>
        </div>
        <a href="{{ route('guru.presensi.index') }}" class="btn btn-ghost btn-sm text-xs">
            ← Kembali ke Input Presensi
        </a>
    </div>

    <!-- Filter Card -->
    <div class="card bg-base-100 shadow-sm border border-base-300">
        <div class="card-body p-4">
            <form method="GET" action="{{ route('guru.presensi.rekap') }}" class="flex flex-col sm:flex-row gap-3 items-end">
                <select name="bulan" class="select select-bordered select-sm w-full sm:w-auto text-xs">
                    @for($m = 1; $m <= 12; $m++)
                        <option value="{{ $m }}" {{ $bulan == $m ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::create()->month($m)->isoFormat('MMMM') }}
                        </option>
                    @endfor
                </select>

                <select name="tahun" class="select select-bordered select-sm w-full sm:w-auto text-xs">
                    @for($y = date('Y') - 2; $y <= date('Y') + 1; $y++)
                        <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>

                <select name="jilid" class="select select-bordered select-sm w-full sm:w-auto text-xs">
                    <option value="">-- Semua Jilid --</option>
                    @foreach($daftarJilid as $j)
                        <option value="{{ $j }}" {{ $selectedJilid === $j ? 'selected' : '' }}>{{ $j }}</option>
                    @endforeach
                </select>

                <div class="flex gap-2 w-full sm:w-auto">
                    <button type="submit" class="btn btn-sm btn-outline btn-primary text-xs flex-1 sm:flex-none">
                        Cari / Filter
                    </button>
                    @if($selectedJilid)
                        <a href="{{ route('guru.presensi.rekap') }}" class="btn btn-sm btn-ghost text-xs">Reset</a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- Summary Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
        @php
            $totalSantri = $santriList->count();
            $totalHadir = 0;
            $totalIzin = 0;
            $totalSakit = 0;
            $totalAlpa = 0;
            
            foreach($santriList as $santri) {
                $totalHadir += $santri->presensi->where('status', 'Hadir')->count();
                $totalIzin += $santri->presensi->where('status', 'Izin')->count();
                $totalSakit += $santri->presensi->where('status', 'Sakit')->count();
                $totalAlpa += $santri->presensi->where('status', 'Alpa')->count();
            }
        @endphp

        <div class="stat bg-base-100 shadow-sm border border-base-300 rounded-lg p-4">
            <div class="stat-title text-xs">Total Hadir</div>
            <div class="stat-value text-2xl text-success">{{ $totalHadir }}</div>
            <div class="stat-desc text-xs">Kehadiran santri</div>
        </div>

        <div class="stat bg-base-100 shadow-sm border border-base-300 rounded-lg p-4">
            <div class="stat-title text-xs">Total Izin</div>
            <div class="stat-value text-2xl text-info">{{ $totalIzin }}</div>
            <div class="stat-desc text-xs">Izin resmi</div>
        </div>

        <div class="stat bg-base-100 shadow-sm border border-base-300 rounded-lg p-4">
            <div class="stat-title text-xs">Total Sakit</div>
            <div class="stat-value text-2xl text-warning">{{ $totalSakit }}</div>
            <div class="stat-desc text-xs">Sakit</div>
        </div>

        <div class="stat bg-base-100 shadow-sm border border-base-300 rounded-lg p-4">
            <div class="stat-title text-xs">Total Alpa</div>
            <div class="stat-value text-2xl text-error">{{ $totalAlpa }}</div>
            <div class="stat-desc text-xs">Tanpa keterangan</div>
        </div>
    </div>

    <!-- Rekap Table -->
    <div class="card bg-base-100 shadow-sm border border-base-300">
        <div class="card-body p-0">
            <div class="overflow-x-auto">
                <table class="table table-zebra table-sm">
                    <thead class="bg-base-200 text-base-content/70 text-xs">
                        <tr>
                            <th class="text-center">No</th>
                            <th>NIS</th>
                            <th>Nama Santri</th>
                            <th class="text-center">Jilid</th>
                            <th class="text-center bg-success/10">Hadir</th>
                            <th class="text-center bg-info/10">Izin</th>
                            <th class="text-center bg-warning/10">Sakit</th>
                            <th class="text-center bg-error/10">Alpa</th>
                            <th class="text-center">Total</th>
                            <th class="text-center">% Kehadiran</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($santriList as $index => $santri)
                            @php
                                $hadir = $santri->presensi->where('status', 'Hadir')->count();
                                $izin = $santri->presensi->where('status', 'Izin')->count();
                                $sakit = $santri->presensi->where('status', 'Sakit')->count();
                                $alpa = $santri->presensi->where('status', 'Alpa')->count();
                                $total = $santri->presensi->count();
                                $persentase = $total > 0 ? round(($hadir / $total) * 100, 1) : 0;
                            @endphp
                            <tr class="hover">
                                <td class="text-xs text-base-content/60 text-center">{{ $index + 1 }}</td>
                                <td class="font-mono text-xs font-bold text-emerald-800">{{ $santri->nis }}</td>
                                <td>
                                    <div class="font-bold text-xs">{{ $santri->nama_lengkap }}</div>
                                </td>
                                <td class="text-center">
                                    <span class="badge badge-xs badge-ghost font-medium">{{ $santri->jilid_kelas }}</span>
                                </td>
                                <td class="text-center font-bold text-xs text-success">{{ $hadir }}</td>
                                <td class="text-center font-bold text-xs text-info">{{ $izin }}</td>
                                <td class="text-center font-bold text-xs text-warning">{{ $sakit }}</td>
                                <td class="text-center font-bold text-xs text-error">{{ $alpa }}</td>
                                <td class="text-center font-bold text-xs">{{ $total }}</td>
                                <td class="text-center">
                                    @if($persentase >= 90)
                                        <span class="badge badge-sm badge-success text-white font-bold">{{ $persentase }}%</span>
                                    @elseif($persentase >= 75)
                                        <span class="badge badge-sm badge-info text-white font-bold">{{ $persentase }}%</span>
                                    @elseif($persentase >= 60)
                                        <span class="badge badge-sm badge-warning text-white font-bold">{{ $persentase }}%</span>
                                    @else
                                        <span class="badge badge-sm badge-error text-white font-bold">{{ $persentase }}%</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center py-8 text-base-content/50 text-xs">
                                    Tidak ada data presensi untuk periode yang dipilih.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
