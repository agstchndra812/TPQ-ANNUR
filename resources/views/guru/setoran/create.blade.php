@extends('layouts.guru')

@section('title', 'Catat Setoran Hafalan')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-base-content">Catat Setoran Hafalan</h1>
            <p class="text-xs text-base-content/60">Input penilaian setoran ziyadah atau muraja'ah santri</p>
        </div>
        <a href="{{ route('guru.setoran.index') }}" class="btn btn-ghost btn-sm text-xs">
            ← Kembali
        </a>
    </div>

    <div class="card bg-base-100 shadow-sm border border-base-300">
        <div class="card-body p-6">
            <form method="POST" action="{{ route('guru.setoran.store') }}" class="space-y-4">
                @csrf

                <!-- Santri & Tanggal -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="form-control">
                        <label class="label py-1">
                            <span class="label-text font-semibold text-xs">Santri <span class="text-error">*</span></span>
                        </label>
                        <select name="santri_id" required class="select select-bordered select-sm text-xs @error('santri_id') select-error @enderror">
                            <option value="">-- Pilih Santri --</option>
                            @foreach($santriList as $s)
                                <option value="{{ $s->id }}" {{ old('santri_id') == $s->id ? 'selected' : '' }}>
                                    {{ $s->nama_lengkap }} ({{ $s->jilid_kelas }})
                                </option>
                            @endforeach
                        </select>
                        @error('santri_id')
                            <span class="text-error text-[11px] mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-control">
                        <label class="label py-1">
                            <span class="label-text font-semibold text-xs">Tanggal Setoran <span class="text-error">*</span></span>
                        </label>
                        <input type="date" name="tanggal_setoran" value="{{ old('tanggal_setoran', date('Y-m-d')) }}" required class="input input-bordered input-sm text-xs @error('tanggal_setoran') input-error @enderror" />
                        @error('tanggal_setoran')
                            <span class="text-error text-[11px] mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Jenis & Surah -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="form-control">
                        <label class="label py-1">
                            <span class="label-text font-semibold text-xs">Jenis Setoran <span class="text-error">*</span></span>
                        </label>
                        <select name="jenis" required class="select select-bordered select-sm text-xs @error('jenis') select-error @enderror">
                            <option value="ziyadah" {{ old('jenis', 'ziyadah') === 'ziyadah' ? 'selected' : '' }}>Ziyadah (Hafalan Baru)</option>
                            <option value="murajaah" {{ old('jenis') === 'murajaah' ? 'selected' : '' }}>Muraja'ah (Pengulangan)</option>
                        </select>
                        @error('jenis')
                            <span class="text-error text-[11px] mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-control">
                        <label class="label py-1">
                            <span class="label-text font-semibold text-xs">Surah <span class="text-error">*</span></span>
                        </label>
                        <select id="surah-select" name="surah_id" required onchange="updateMaxAyat(this)" class="select select-bordered select-sm text-xs @error('surah_id') select-error @enderror">
                            <option value="">-- Pilih Surah --</option>
                            @foreach($surahList as $surah)
                                <option value="{{ $surah->id }}" data-ayat="{{ $surah->jumlah_ayat }}" {{ old('surah_id') == $surah->id ? 'selected' : '' }}>
                                    {{ $surah->nomor_surah }}. {{ $surah->nama_surah }} ({{ $surah->jumlah_ayat }} ayat, Juz {{ $surah->juz }})
                                </option>
                            @endforeach
                        </select>
                        @error('surah_id')
                            <span class="text-error text-[11px] mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Rentang Ayat -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="form-control">
                        <label class="label py-1">
                            <span class="label-text font-semibold text-xs">Ayat Mulai</span>
                        </label>
                        <input type="number" id="ayat_mulai" name="ayat_mulai" value="{{ old('ayat_mulai', 1) }}" min="1" class="input input-bordered input-sm text-xs @error('ayat_mulai') input-error @enderror" />
                        @error('ayat_mulai')
                            <span class="text-error text-[11px] mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-control">
                        <label class="label py-1">
                            <span class="label-text font-semibold text-xs">Ayat Selesai</span>
                            <span id="max-ayat-hint" class="label-text-alt text-base-content/50"></span>
                        </label>
                        <input type="number" id="ayat_selesai" name="ayat_selesai" value="{{ old('ayat_selesai', 1) }}" min="1" class="input input-bordered input-sm text-xs @error('ayat_selesai') input-error @enderror" />
                        @error('ayat_selesai')
                            <span class="text-error text-[11px] mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Penilaian -->
                <div class="form-control">
                    <label class="label py-1">
                        <span class="label-text font-semibold text-xs">Penilaian Kelancaran <span class="text-error">*</span></span>
                    </label>
                    <select name="nilai" required class="select select-bordered select-sm text-xs @error('nilai') select-error @enderror">
                        <option value="">-- Pilih Penilaian --</option>
                        <option value="Mumtaz" {{ old('nilai') === 'Mumtaz' ? 'selected' : '' }}>Mumtaz (Sangat Lancar)</option>
                        <option value="Jayyid" {{ old('nilai') === 'Jayyid' ? 'selected' : '' }}>Jayyid (Lancar)</option>
                        <option value="Mengulang" {{ old('nilai') === 'Mengulang' ? 'selected' : '' }}>Mengulang</option>
                    </select>
                    @error('nilai')
                        <span class="text-error text-[11px] mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Catatan -->
                <div class="form-control">
                    <label class="label py-1">
                        <span class="label-text font-semibold text-xs">Catatan Evaluasi / Tajwid</span>
                    </label>
                    <textarea name="catatan" rows="3" placeholder="Contoh: Sangat fasih, perhatikan kembali panjang mad thobi'i pada ayat 10." class="textarea textarea-bordered textarea-sm text-xs @error('catatan') textarea-error @enderror">{{ old('catatan') }}</textarea>
                    @error('catatan')
                        <span class="text-error text-[11px] mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex justify-end gap-2 pt-4 border-t border-base-200">
                    <a href="{{ route('guru.setoran.index') }}" class="btn btn-ghost btn-sm text-xs">Batal</a>
                    <button type="submit" class="btn btn-primary bg-emerald-600 hover:bg-emerald-700 text-white btn-sm text-xs font-bold">
                        Simpan Setoran
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function updateMaxAyat(select) {
        const selectedOption = select.options[select.selectedIndex];
        const totalAyat = selectedOption.getAttribute('data-ayat');
        if (totalAyat) {
            document.getElementById('max-ayat-hint').textContent = '(Maks: ' + totalAyat + ' ayat)';
            document.getElementById('ayat_selesai').setAttribute('max', totalAyat);
        } else {
            document.getElementById('max-ayat-hint').textContent = '';
        }
    }
    document.addEventListener('DOMContentLoaded', function() {
        const sel = document.getElementById('surah-select');
        if (sel) updateMaxAyat(sel);
    });
</script>
@endsection
