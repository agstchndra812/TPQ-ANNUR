@extends('layouts.superadmin')

@section('title', 'Tambah Guru Baru')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex items-center gap-3">
        <a href="{{ route('superadmin.guru.index') }}" class="btn btn-ghost btn-sm btn-square">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-base-content">Tambah Guru Baru</h1>
            <p class="text-sm text-base-content/60 mt-1">Buat akun login baru untuk guru / ustadz TPQ</p>
        </div>
    </div>

    <!-- Form Card -->
    <div class="card bg-base-100 shadow-sm border border-base-300 max-w-2xl">
        <div class="card-body">
            <form method="POST" action="{{ route('superadmin.guru.store') }}">
                @csrf

                <!-- Nama Lengkap -->
                <div class="form-control mb-4">
                    <label class="label">
                        <span class="label-text font-semibold">Nama Lengkap <span class="text-error">*</span></span>
                    </label>
                    <input type="text" name="name" value="{{ old('name') }}" required class="input input-bordered @error('name') input-error @enderror" placeholder="Nama lengkap guru" />
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
                    <input type="email" name="email" value="{{ old('email') }}" required class="input input-bordered @error('email') input-error @enderror" placeholder="email@example.com" />
                    @error('email')
                        <label class="label">
                            <span class="label-text-alt text-error">{{ $message }}</span>
                        </label>
                    @enderror
                    <label class="label">
                        <span class="label-text-alt">Email ini akan digunakan untuk login</span>
                    </label>
                </div>

                <!-- Password -->
                <div class="form-control mb-4">
                    <label class="label">
                        <span class="label-text font-semibold">Kata Sandi <span class="text-error">*</span></span>
                    </label>
                    <input type="password" name="password" required class="input input-bordered @error('password') input-error @enderror" placeholder="Minimal 6 karakter" />
                    @error('password')
                        <label class="label">
                            <span class="label-text-alt text-error">{{ $message }}</span>
                        </label>
                    @enderror
                    <label class="label">
                        <span class="label-text-alt">Minimal 6 karakter</span>
                    </label>
                </div>

                <!-- Actions -->
                <div class="flex gap-3 mt-6">
                    <button type="submit" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                        Simpan Data Guru
                    </button>
                    <a href="{{ route('superadmin.guru.index') }}" class="btn btn-ghost">Batal</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Info Alert -->
    <div class="alert alert-info max-w-2xl">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-current shrink-0 w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        <div class="text-xs">
            <strong>Catatan:</strong> Akun guru hanya dapat mengakses menu presensi dan setoran hafalan. Untuk mengelola master data, gunakan akun SuperAdmin.
        </div>
    </div>
</div>
@endsection
