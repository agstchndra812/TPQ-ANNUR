@extends('layouts.superadmin')

@section('title', 'Edit Data Wali Santri')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-base-content">Edit Data Wali Santri</h1>
            <p class="text-xs text-base-content/60">Perbarui informasi wali santri: {{ $orangTua->user->name ?? 'Orang Tua' }}</p>
        </div>
        <a href="{{ route('superadmin.orang_tua.index') }}" class="btn btn-ghost btn-sm text-xs">
            ← Kembali
        </a>
    </div>

    <div class="card bg-base-100 shadow-sm border border-base-300">
        <div class="card-body p-6">
            <form method="POST" action="{{ route('superadmin.orang_tua.update', $orangTua) }}" class="space-y-4">
                @csrf
                @method('PUT')

                <div class="divider text-xs font-bold text-base-content/70">DATA AKUN LOGIN</div>

                <div class="form-control">
                    <label class="label py-1">
                        <span class="label-text font-semibold text-xs">Nama Lengkap Wali Santri <span class="text-error">*</span></span>
                    </label>
                    <input type="text" name="name" value="{{ old('name', $orangTua->user->name) }}" required placeholder="Nama lengkap orang tua / wali" class="input input-bordered input-sm text-xs @error('name') input-error @enderror" />
                    @error('name')
                        <span class="text-error text-[11px] mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="form-control">
                        <label class="label py-1">
                            <span class="label-text font-semibold text-xs">Email <span class="text-error">*</span></span>
                        </label>
                        <input type="email" name="email" value="{{ old('email', $orangTua->user->email) }}" required placeholder="email@example.com" class="input input-bordered input-sm text-xs @error('email') input-error @enderror" />
                        @error('email')
                            <span class="text-error text-[11px] mt-1">{{ $message }}</span>
                        @enderror
                        <label class="label py-0">
                            <span class="label-text-alt text-base-content/50">Digunakan untuk login ke sistem</span>
                        </label>
                    </div>

                    <div class="form-control">
                        <label class="label py-1">
                            <span class="label-text font-semibold text-xs">Password Baru</span>
                        </label>
                        <input type="password" name="password" placeholder="Kosongkan jika tidak diubah" class="input input-bordered input-sm text-xs @error('password') input-error @enderror" />
                        @error('password')
                            <span class="text-error text-[11px] mt-1">{{ $message }}</span>
                        @enderror
                        <label class="label py-0">
                            <span class="label-text-alt text-base-content/50">Minimal 6 karakter jika diisi</span>
                        </label>
                    </div>
                </div>

                <div class="divider text-xs font-bold text-base-content/70">DATA KONTAK</div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="form-control">
                        <label class="label py-1">
                            <span class="label-text font-semibold text-xs">Nomor HP / WhatsApp</span>
                        </label>
                        <input type="text" name="no_hp" value="{{ old('no_hp', $orangTua->no_hp) }}" placeholder="Contoh: 081234567890" class="input input-bordered input-sm text-xs @error('no_hp') input-error @enderror" />
                        @error('no_hp')
                            <span class="text-error text-[11px] mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-control">
                    <label class="label py-1">
                        <span class="label-text font-semibold text-xs">Alamat Lengkap</span>
                    </label>
                    <textarea name="alamat" rows="3" placeholder="Alamat rumah orang tua" class="textarea textarea-bordered textarea-sm text-xs @error('alamat') textarea-error @enderror">{{ old('alamat', $orangTua->alamat) }}</textarea>
                    @error('alamat')
                        <span class="text-error text-[11px] mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex justify-end gap-2 pt-4 border-t border-base-200">
                    <a href="{{ route('superadmin.orang_tua.index') }}" class="btn btn-ghost btn-sm text-xs">Batal</a>
                    <button type="submit" class="btn btn-primary bg-emerald-600 hover:bg-emerald-700 text-white btn-sm text-xs font-bold">
                        Perbarui Data Wali Santri
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
