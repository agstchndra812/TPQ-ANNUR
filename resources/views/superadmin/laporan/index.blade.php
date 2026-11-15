@extends('layouts.superadmin')

@section('title', 'Cetak Rapor Santri')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-base-content">Laporan & Rapor Digital Santri</h1>
            <p class="text-xs text-base-content/60">Cetak lembar rapor resmi perkembangan hafalan dan kehadiran format PDF</p>
        </div>
    </div>

    <!-- Filter Card -->
    <div class="card bg-base-100 shadow-sm border border-base-300">
        <div class="card-body p-4">
            <form id="filter-form" method="GET" action="{{ route('superadmin.laporan.index') }}" class="flex flex-col sm:flex-row gap-3 items-end">
                <input type="text" name="search" value="{{ $search }}" placeholder="Cari santri..." class="input input-bordered input-sm w-full sm:flex-1 text-xs" />

                <select name="jilid" class="select select-bordered select-sm w-full sm:w-auto text-xs">
                    <option value="">-- Semua Jilid --</option>
                    @foreach($daftarJilid as $j)
                        <option value="{{ $j }}" {{ $selectedJilid === $j ? 'selected' : '' }}>{{ $j }}</option>
                    @endforeach
                </select>

                <select id="select-bulan" name="bulan" class="select select-bordered select-sm w-full sm:w-auto text-xs">
                    @php
                        $months = [
                            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                        ];
                        $curBulan = request('bulan', $currentMonth);
                        $curTahun = request('tahun', $currentYear);
                    @endphp
                    @foreach($months as $num => $name)
                        <option value="{{ $num }}" {{ $curBulan == $num ? 'selected' : '' }}>{{ $name }}</option>
                    @endforeach
                </select>

                <select id="select-tahun" name="tahun" class="select select-bordered select-sm w-full sm:w-auto text-xs">
                    @for($y = date('Y') - 2; $y <= date('Y') + 1; $y++)
                        <option value="{{ $y }}" {{ $curTahun == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>

                <div class="flex gap-2 w-full sm:w-auto">
                    <button type="submit" class="btn btn-sm btn-outline btn-primary text-xs flex-1 sm:flex-none">
                        Cari / Filter
                    </button>
                    @if($search || $selectedJilid)
                        <a href="{{ route('superadmin.laporan.index') }}" class="btn btn-sm btn-ghost text-xs">Reset</a>
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
                            <th class="w-12 text-center">No</th>
                            <th>NIS</th>
                            <th>Nama Santri</th>
                            <th>Jilid / Kelas</th>
                            <th>Wali Santri</th>
                            <th class="text-center">Periode Rapor</th>
                            <th class="text-center">Cetak Rapor</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($santriList as $index => $santri)
                            <tr class="hover">
                                <td class="text-center text-xs text-base-content/60">{{ $santriList->firstItem() + $index }}</td>
                                <td class="font-mono text-xs font-bold text-emerald-800">{{ $santri->nis }}</td>
                                <td class="font-bold text-xs">{{ $santri->nama_lengkap }}</td>
                                <td>
                                    <span class="badge badge-xs badge-ghost font-semibold">{{ $santri->jilid_kelas }}</span>
                                </td>
                                <td class="text-xs text-base-content/70">
                                    {{ $santri->orangTua->user->name ?? '-' }}
                                </td>
                                <td class="text-center text-xs font-medium">
                                    {{ $months[$curBulan] }} {{ $curTahun }}
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('superadmin.laporan.rapor', [$santri, 'bulan' => $curBulan, 'tahun' => $curTahun]) }}" target="_blank" class="btn btn-xs btn-primary bg-emerald-600 hover:bg-emerald-700 text-white font-bold gap-1 shadow-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" /></svg>
                        Cetak PDF
                    </a>
                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-8 text-base-content/50 text-xs">
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
