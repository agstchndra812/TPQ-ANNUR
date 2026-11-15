@extends('layouts.parent')

@section('title', 'Monitoring Perkembangan Santri')

@section('content')
<div class="space-y-6">
    <!-- Child Selector (If parent has multiple children) -->
    @if($santriList->count() > 1)
        <div class="card bg-base-100 shadow-sm border border-base-300">
            <div class="card-body p-4">
                <span class="text-xs font-semibold text-base-content/60 uppercase tracking-wider mb-2 block">Pilih Ananda yang Dipantau:</span>
                <div class="flex flex-wrap gap-2">
                    @foreach($santriList as $child)
                        <a href="{{ route('parent.dashboard', ['santri_id' => $child->id]) }}"
                           class="btn btn-sm {{ $activeSantri && $activeSantri->id === $child->id ? 'btn-primary bg-emerald-700 text-white font-bold' : 'btn-outline border-base-300 font-medium' }} text-xs">
                            {{ $child->jenis_kelamin }} - {{ $child->nama_lengkap }} ({{ $child->jilid_kelas }})
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    @if(!$activeSantri)
        <div class="card bg-base-100 shadow-md border border-base-300 text-center p-8">
            <div class="p-4 bg-amber-50 text-amber-700 rounded-full w-16 h-16 mx-auto mb-3 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            </div>
            <h2 class="text-lg font-bold">Belum Ada Data Santri Terhubung</h2>
            <p class="text-xs text-base-content/60 max-w-sm mx-auto mt-1">Akun wali santri Anda belum dihubungkan ke data santri. Silakan hubungi ustadz/pengurus TPQ Annur untuk penautan akun.</p>
        </div>
    @else
        <!-- Child Header & Profile Card -->
        <div class="card bg-gradient-to-r from-emerald-800 to-teal-700 text-white shadow-lg overflow-hidden">
            <div class="card-body p-5 sm:p-6">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-2xl bg-white/20 flex items-center justify-center text-2xl font-black text-white shrink-0 border border-white/30">
                            {{ strtoupper(substr($activeSantri->nama_lengkap, 0, 1)) }}
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <h1 class="text-xl sm:text-2xl font-black">{{ $activeSantri->nama_lengkap }}</h1>
                                <span class="badge badge-sm bg-white/20 text-white border-none font-bold">
                                    {{ $activeSantri->jenis_kelamin === 'L' ? 'Putra' : 'Putri' }}
                                </span>
                            </div>
                            <div class="text-xs text-emerald-100 flex flex-wrap gap-x-3 gap-y-1 mt-1">
                                <span>NIS: <b class="font-mono text-white">{{ $activeSantri->nis }}</b></span>
                                <span>•</span>
                                <span>Tingkat: <b class="text-white">{{ $activeSantri->jilid_kelas }}</b></span>
                                @if($activeSantri->tanggal_lahir)
                                    <span>•</span>
                                    <span>Lahir: <b class="text-white">{{ $activeSantri->tanggal_lahir->format('d M Y') }}</b></span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- PDF Report Button -->
                    <a href="{{ route('parent.rapor', [$activeSantri, 'bulan' => $currentMonth, 'tahun' => $currentYear]) }}" target="_blank" class="btn btn-sm bg-white hover:bg-emerald-50 text-emerald-800 border-none font-bold text-xs shadow-md shrink-0 w-full sm:w-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                        Unduh Rapor PDF ({{ $currentMonthName }})
                    </a>
                </div>
            </div>
        </div>

        <!-- 3 Quick Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <!-- Kehadiran Bulan Ini -->
            <div class="card bg-base-100 shadow-sm border border-base-300">
                <div class="card-body p-4">
                    <span class="text-xs font-semibold text-base-content/60 uppercase tracking-wider">Kehadiran ({{ $currentMonthName }})</span>
                    <div class="text-2xl font-black text-emerald-700 mt-1">
                        {{ $stats['persentaseKehadiran'] }}%
                    </div>
                    <div class="flex gap-1 mt-1 text-[11px] text-base-content/70">
                        <span class="badge badge-xs badge-success text-white">H: {{ $stats['totalHadir'] }}</span>
                        <span class="badge badge-xs badge-info text-white">I: {{ $stats['totalIzin'] }}</span>
                        <span class="badge badge-xs badge-warning text-white">S: {{ $stats['totalSakit'] }}</span>
                        <span class="badge badge-xs badge-error text-white">A: {{ $stats['totalAlpa'] }}</span>
                    </div>
                </div>
            </div>

            <!-- Setoran Ziyadah (Baru) -->
            <div class="card bg-base-100 shadow-sm border border-base-300">
                <div class="card-body p-4">
                    <span class="text-xs font-semibold text-base-content/60 uppercase tracking-wider">Setoran Ziyadah (Hafalan Baru)</span>
                    <div class="text-2xl font-black text-base-content mt-1">
                        {{ $stats['totalZiyadah'] }} <span class="text-xs font-normal text-base-content/50">Kali Setor</span>
                    </div>
                    <div class="text-[11px] text-base-content/70 mt-1 truncate">
                        @if($stats['latestZiyadah'])
                            Terakhir: <b>{{ $stats['latestZiyadah']->surah->nama_surah }} ({{ $stats['latestZiyadah']->ayat_mulai }}-{{ $stats['latestZiyadah']->ayat_selesai }})</b>
                        @else
                            <span class="italic text-base-content/40">Belum ada setoran</span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Setoran Muraja'ah (Pengulangan) -->
            <div class="card bg-base-100 shadow-sm border border-base-300">
                <div class="card-body p-4">
                    <span class="text-xs font-semibold text-base-content/60 uppercase tracking-wider">Muraja'ah (Pengulangan)</span>
                    <div class="text-2xl font-black text-base-content mt-1">
                        {{ $stats['totalMurajaah'] }} <span class="text-xs font-normal text-base-content/50">Kali Ulang</span>
                    </div>
                    <div class="text-[11px] text-base-content/70 mt-1 truncate">
                        @if($stats['latestMurajaah'])
                            Terakhir: <b>{{ $stats['latestMurajaah']->surah->nama_surah }} ({{ $stats['latestMurajaah']->ayat_mulai }}-{{ $stats['latestMurajaah']->ayat_selesai }})</b>
                        @else
                            <span class="italic text-base-content/40">Belum ada muraja'ah</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Feed Setoran Hafalan -->
        <div class="card bg-base-100 shadow-sm border border-base-300">
            <div class="card-body p-5">
                <div class="flex items-center justify-between mb-2">
                    <div>
                        <h2 class="card-title text-base font-bold">Riwayat Setoran Hafalan</h2>
                        <p class="text-xs text-base-content/60">Catatan perkembangan hafalan dan evaluasi dari ustadz</p>
                    </div>
                </div>

                @if($recentSetoran->isEmpty())
                    <div class="text-center py-8 text-base-content/40 text-xs italic">
                        Belum ada catatan setoran untuk santri ini.
                    </div>
                @else
                    <div class="divide-y divide-base-200">
                        @foreach($recentSetoran as $setoran)
                            <div class="py-3 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2">
                                <div class="space-y-1">
                                    <div class="flex items-center gap-2">
                                        <span class="font-bold text-sm text-emerald-800">
                                            Surah {{ $setoran->surah->nama_surah }}
                                        </span>
                                        <span class="text-xs font-medium text-base-content/70">
                                            Ayat {{ $setoran->ayat_mulai }} - {{ $setoran->ayat_selesai }}
                                        </span>
                                        @if($setoran->jenis === 'ziyadah')
                                            <span class="badge badge-xs badge-primary">Ziyadah</span>
                                        @else
                                            <span class="badge badge-xs badge-neutral">Muraja'ah</span>
                                        @endif
                                    </div>
                                    @if($setoran->catatan)
                                        <div class="text-xs text-base-content/70 bg-base-200/60 p-2 rounded-lg border-l-2 border-emerald-600">
                                            💬 <i>"{{ $setoran->catatan }}"</i>
                                        </div>
                                    @endif
                                </div>

                                <div class="flex sm:flex-col items-center sm:items-end justify-between w-full sm:w-auto gap-1 shrink-0">
                                    @if($setoran->nilai === 'Mumtaz')
                                        <span class="badge badge-sm badge-success text-white font-bold">Mumtaz (Sangat Lancar)</span>
                                    @elseif($setoran->nilai === 'Jayyid')
                                        <span class="badge badge-sm badge-info text-white font-bold">Jayyid (Lancar)</span>
                                    @else
                                        <span class="badge badge-sm badge-warning text-white font-bold">Mengulang</span>
                                    @endif
                                    <span class="text-[11px] text-base-content/50">
                                        {{ $setoran->tanggal_setoran->isoFormat('D MMM Y') }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <!-- Riwayat Presensi -->
        <div class="card bg-base-100 shadow-sm border border-base-300">
            <div class="card-body p-5">
                <h2 class="card-title text-base font-bold mb-1">Riwayat Presensi Terakhir</h2>
                <p class="text-xs text-base-content/60 mb-3">Catatan kedisiplinan mengaji harian</p>

                @if($recentPresensi->isEmpty())
                    <div class="text-center py-6 text-base-content/40 text-xs italic">
                        Belum ada data presensi tercatat.
                    </div>
                @else
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-2">
                        @foreach($recentPresensi as $p)
                            <div class="p-2.5 rounded-xl border border-base-200 bg-base-50 text-center">
                                <div class="text-xs font-semibold">{{ $p->tanggal->format('d/m/Y') }}</div>
                                <div class="mt-1">
                                    @if($p->status === 'Hadir')
                                        <span class="badge badge-xs badge-success text-white font-bold">Hadir</span>
                                    @elseif($p->status === 'Izin')
                                        <span class="badge badge-xs badge-info text-white font-bold">Izin</span>
                                    @elseif($p->status === 'Sakit')
                                        <span class="badge badge-xs badge-warning text-white font-bold">Sakit</span>
                                    @else
                                        <span class="badge badge-xs badge-error text-white font-bold">Alpa</span>
                                    @endif
                                </div>
                                @if($p->keterangan)
                                    <div class="text-[10px] text-base-content/60 truncate mt-1" title="{{ $p->keterangan }}">
                                        {{ $p->keterangan }}
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    @endif
</div>
@endsection

