@extends('layouts.superadmin')

@section('title', 'Edit Data Santri')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-base-content">Edit Data Santri</h1>
            <p class="text-xs text-base-content/60">Perbarui informasi santri: {{ $santri->nama_lengkap }}</p>
        </div>
        <a href="{{ route('superadmin.santri.index') }}" class="btn btn-ghost btn-sm text-xs">
            ← Kembali
        </a>
    </div>

    <div class="card bg-base-100 shadow-sm border border-base-300">
        <div class="card-body p-6">
            <form method="POST" action="{{ route('superadmin.santri.update', $santri) }}" class="space-y-4">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="form-control">
                        <label class="label py-1">
                            <span class="label-text font-semibold text-xs">Nomor Induk Santri (NIS) <span class="text-error">*</span></span>
                        </label>
                        <input type="text" name="nis" value="{{ old('nis', $santri->nis) }}" required placeholder="Contoh: 2026005" class="input input-bordered input-sm text-xs @error('nis') input-error @enderror" />
                        @error('nis')
                            <span class="text-error text-[11px] mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-control">
                        <label class="label py-1">
                            <span class="label-text font-semibold text-xs">Jilid / Tingkat Kelas <span class="text-error">*</span></span>
                        </label>
                        <select name="jilid_kelas" required class="select select-bordered select-sm text-xs @error('jilid_kelas') select-error @enderror">
                            <option value="">-- Pilih Jilid --</option>
                            @foreach($daftarJilid as $j)
                                <option value="{{ $j }}" {{ old('jilid_kelas', $santri->jilid_kelas) === $j ? 'selected' : '' }}>{{ $j }}</option>
                            @endforeach
                        </select>
                        @error('jilid_kelas')
                            <span class="text-error text-[11px] mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-control">
                    <label class="label py-1">
                        <span class="label-text font-semibold text-xs">Nama Lengkap Santri <span class="text-error">*</span></span>
                    </label>
                    <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $santri->nama_lengkap) }}" required placeholder="Nama lengkap santri" class="input input-bordered input-sm text-xs @error('nama_lengkap') input-error @enderror" />
                    @error('nama_lengkap')
                        <span class="text-error text-[11px] mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="form-control">
                        <label class="label py-1">
                            <span class="label-text font-semibold text-xs">Jenis Kelamin <span class="text-error">*</span></span>
                        </label>
                        <select name="jenis_kelamin" required class="select select-bordered select-sm text-xs @error('jenis_kelamin') select-error @enderror">
                            <option value="L" {{ old('jenis_kelamin', $santri->jenis_kelamin) === 'L' ? 'selected' : '' }}>Laki-laki (Putra)</option>
                            <option value="P" {{ old('jenis_kelamin', $santri->jenis_kelamin) === 'P' ? 'selected' : '' }}>Perempuan (Putri)</option>
                        </select>
                    </div>

                    <div class="form-control">
                        <label class="label py-1">
                            <span class="label-text font-semibold text-xs">Tempat Lahir</span>
                        </label>
                        <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir', $santri->tempat_lahir) }}" placeholder="Kota kelahiran" class="input input-bordered input-sm text-xs" />
                    </div>

                    <div class="form-control">
                        <label class="label py-1">
                            <span class="label-text font-semibold text-xs">Tanggal Lahir</span>
                        </label>
                        <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $santri->tanggal_lahir?->format('Y-m-d')) }}" class="input input-bordered input-sm text-xs" />
                    </div>
                </div>

                <div class="form-control">
                    <label class="label py-1">
                        <span class="label-text font-semibold text-xs">Hubungkan dengan Wali Santri (Orang Tua)</span>
                    </label>
                    <select name="orang_tua_id" class="select select-bordered select-sm text-xs">
                        <option value="">-- Belum Dihubungkan / Pilih Nanti --</option>
                        @foreach($orangTuaList as $ot)
                            <option value="{{ $ot->id }}" {{ old('orang_tua_id', $santri->orang_tua_id) == $ot->id ? 'selected' : '' }}>
                                {{ $ot->user->name ?? 'User #'.$ot->id }} ({{ $ot->user->email ?? '-' }}) - {{ $ot->no_hp ?? 'No HP belum ada' }}
                            </option>
                        @endforeach
                    </select>
                    <label class="label py-0">
                        <span class="label-text-alt text-base-content/50">Wali santri dapat melihat progres santri ini di portal khusus.</span>
                    </label>
                </div>

                <div class="form-control pt-2">
                    <label class="cursor-pointer label justify-start gap-3 p-0">
                        <input type="checkbox" name="status_aktif" value="1" {{ old('status_aktif', $santri->status_aktif) ? 'checked' : '' }} class="checkbox checkbox-sm checkbox-primary" />
                        <span class="label-text font-medium text-xs">Status Santri Aktif Mengaji di TPQ</span>
                    </label>
                </div>

                <div class="flex justify-end gap-2 pt-4 border-t border-base-200">
                    <a href="{{ route('superadmin.santri.index') }}" class="btn btn-ghost btn-sm text-xs">Batal</a>
                    <button type="submit" class="btn btn-primary bg-emerald-600 hover:bg-emerald-700 text-white btn-sm text-xs font-bold">
                        Perbarui Data Santri
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
