@extends('layouts.superadmin')

@section('title', 'Edit Data Guru')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex items-center gap-3">
        <a href="{{ route('superadmin.guru.index') }}" class="btn btn-ghost btn-sm btn-square">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-base-content">Edit Data Guru</h1>
            <p class="text-sm text-base-content/60 mt-1">Ubah informasi akun guru: {{ $guru->name }}</p>
        </div>
    </div>

    <!-- Form Card -->
    <div class="card bg-base-100 shadow-sm border border-base-300 max-w-2xl">
        <div class="card-body">
            <form method="POST" action="{{ route('superadmin.guru.update', $guru->id) }}">
                @csrf
                @method('PUT')

                <!-- Nama Lengkap -->
                <div class="form-control mb-4">
                    <label class="label">
                        <span class="label-text font-semibold">Nama Lengkap <span class="text-error">*</span></span>
                    </label>
                    <input type="text" name="name" value="{{ old('name', $guru->name) }}" required class="input input-bordered @error('name') input-error @enderror" placeholder="Nama lengkap guru" />
                    @error('name')
                        <label class="label">
                            <span class="label-text-alt text-error">{{ $message }}</span>
                        </label>
                    @enderror
                </div>

                <!-- Email -->
                <div class="form-control mb-4">
                    <label class="label">
                        <span class="label-text font-semibold">Email / Username <span class="text-error">*</span></span>
                    </label>
                    <input type="email" name="email" value="{{ old('email', $guru->email) }}" required class="input input-bordered @error('email') input-error @enderror" placeholder="email@example.com" />
                    @error('email')
                        <label class="label">
                            <span class="label-text-alt text-error">{{ $message }}</span>
                        </label>
                    @enderror
                </div>

                <!-- Password -->
                <div class="form-control mb-4">
                    <label class="label">
                        <span class="label-text font-semibold">Kata Sandi Baru</span>
                    </label>
                    <input type="password" name="password" class="input input-bordered @error('password') input-error @enderror" placeholder="Kosongkan jika tidak ingin mengubah password" />
                    @error('password')
                        <label class="label">
                            <span class="label-text-alt text-error">{{ $message }}</span>
                        </label>
                    @enderror
                    <label class="label">
                        <span class="label-text-alt">Kosongkan jika tidak ingin mengubah password</span>
                    </label>
                </div>

                <!-- Actions -->
                <div class="flex gap-3 mt-6">
                    <button type="submit" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                        Perbarui Data
                    </button>
                    <a href="{{ route('superadmin.guru.index') }}" class="btn btn-ghost">Batal</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Section -->
    <div class="card bg-error/10 border border-error/30 shadow-sm max-w-2xl">
        <div class="card-body">
            <h3 class="font-bold text-error mb-2">Zona Berbahaya</h3>
            <p class="text-sm text-base-content/70 mb-4">Menghapus akun guru akan menghilangkan akses login mereka ke sistem.</p>
            <form method="POST" action="{{ route('superadmin.guru.destroy', $guru->id) }}" onsubmit="return confirm('Yakin ingin menghapus akun guru {{ $guru->name }}? Tindakan ini tidak dapat dibatalkan!');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-error btn-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                    Hapus Akun Guru Ini
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
