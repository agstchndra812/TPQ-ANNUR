@extends('layouts.superadmin')

@section('title', 'Referensi 114 Surah Al-Qur\'an')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div>
        <h1 class="text-2xl font-bold text-base-content">114 Surah Al-Qur'an</h1>
        <p class="text-xs text-base-content/60 mt-1">Referensi lengkap nama surah untuk pencatatan setoran hafalan santri</p>
    </div>

    <!-- Filter Card -->
    <div class="card bg-base-100 shadow-sm border border-base-300">
        <div class="card-body p-4">
            <form method="GET" action="{{ route('superadmin.surah.index') }}" class="flex flex-col sm:flex-row gap-3 items-end">
                <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama atau nomor surah..." class="input input-bordered input-sm w-full sm:flex-1 text-xs" />
                
                <select name="juz" class="select select-bordered select-sm w-full sm:w-auto text-xs">
                    <option value="">-- Semua Juz --</option>
                    @for($i = 1; $i <= 30; $i++)
                        <option value="{{ $i }}" {{ $selectedJuz == $i ? 'selected' : '' }}>Juz {{ $i }}</option>
                    @endfor
                </select>

                <div class="flex gap-2 w-full sm:w-auto">
                    <button type="submit" class="btn btn-sm btn-outline btn-primary text-xs flex-1 sm:flex-none">
                        Cari / Filter
                    </button>
                    @if($search || $selectedJuz)
                        <a href="{{ route('superadmin.surah.index') }}" class="btn btn-sm btn-ghost text-xs">Reset</a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- Surah Table -->
    <div class="card bg-base-100 shadow-sm border border-base-300">
        <div class="card-body p-0">
            <div class="overflow-x-auto">
                <table class="table table-zebra table-sm">
                    <thead class="bg-base-200 text-base-content/70 text-xs">
                        <tr>
                            <th class="w-20 text-center">No.</th>
                            <th>Nama Surah</th>
                            <th class="w-32 text-center">Jumlah Ayat</th>
                            <th class="w-24 text-center">Juz</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($surahs as $surah)
                            <tr class="hover">
                                <td class="font-bold text-emerald-800 text-center">{{ $surah->nomor_surah }}</td>
                                <td class="font-semibold text-emerald-900">{{ $surah->nama_surah }}</td>
                                <td class="text-center">{{ $surah->jumlah_ayat }} Ayat</td>
                                <td class="text-center"><span class="badge badge-sm badge-outline">Juz {{ $surah->juz }}</span></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-8 text-base-content/50 text-xs">
                                    Tidak ada data surah ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($surahs->hasPages())
                <div class="p-4 border-t border-base-200">
                    {{ $surahs->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
