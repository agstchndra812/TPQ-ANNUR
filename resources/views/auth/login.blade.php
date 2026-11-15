<!DOCTYPE html>
<html lang="id" data-theme="emerald">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - TPQ Annur Bogor</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Animate.css for smooth animations -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
</head>
<body class="bg-gradient-to-br from-emerald-900 via-emerald-800 to-teal-900 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-md w-full">
        <!-- Logo & Header -->
        <div class="text-center mb-6">
            <div class="inline-flex p-3 bg-white/10 backdrop-blur-md rounded-2xl shadow-inner mb-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-emerald-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
            </div>
            <h1 class="text-2xl font-black text-white tracking-wide">TPQ ANNUR BOGOR</h1>
            <p class="text-emerald-200 text-xs mt-1">Sistem Monitoring Perkembangan Hafalan & Presensi Santri</p>
        </div>

        <!-- Login Card -->
        <div class="card bg-base-100 shadow-2xl rounded-2xl border border-white/20">
            <div class="card-body p-6 sm:p-8">
                <h2 class="card-title text-xl font-bold text-base-content mb-1">Selamat Datang</h2>
                <p class="text-xs text-base-content/60 mb-4">Silakan masuk menggunakan akun terdaftar Anda</p>

                <form method="POST" action="{{ route('login') }}" class="space-y-4">
                    @csrf

                    <div class="form-control">
                        <label class="label py-1">
                            <span class="label-text font-semibold text-xs">Email / Akun</span>
                        </label>
                        <label class="input input-bordered flex items-center gap-2 w-full @error('email') input-error @enderror">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="w-4 h-4 opacity-70 shrink-0"><path d="M2.5 3A1.5 1.5 0 0 0 1 4.5v.793c.026.009.051.02.076.032L7.674 8.51c.206.1.446.1.652 0l6.598-3.185A.755.755 0 0 1 15 5.293V4.5A1.5 1.5 0 0 0 13.5 3h-11Z" /><path d="M15 6.954 8.978 9.86a2.25 2.25 0 0 1-1.956 0L1 6.954V11.5A1.5 1.5 0 0 0 2.5 13h11a1.5 1.5 0 0 0 1.5-1.5V6.954Z" /></svg>
                            <input id="email-field" type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="nama@email.com" class="grow min-w-0 text-sm" />
                        </label>
                        @error('email')
                            <span class="text-error text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-control">
                        <label class="label py-1">
                            <span class="label-text font-semibold text-xs">Kata Sandi</span>
                        </label>
                        <label class="input input-bordered flex items-center gap-2 w-full @error('password') input-error @enderror">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="w-4 h-4 opacity-70 shrink-0"><path fill-rule="evenodd" d="M14 6a4 4 0 0 1-4.899 3.899l-1.955 1.955a.5.5 0 0 1-.353.146H5v1.5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1-.5-.5v-2.293a.5.5 0 0 1 .146-.353l3.955-3.955A4 4 0 1 1 14 6Zm-4-2a.75.75 0 0 0 0 1.5.5.5 0 0 1 .5.5.75.75 0 0 0 1.5 0 2 2 0 0 0-2-2Z" clip-rule="evenodd" /></svg>
                            <input id="password-field" type="password" name="password" required placeholder="••••••••" class="grow min-w-0 text-sm" />
                        </label>
                        @error('password')
                            <span class="text-error text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex items-center justify-between text-xs py-1">
                        <label class="cursor-pointer label p-0 gap-2">
                            <input type="checkbox" name="remember" class="checkbox checkbox-xs checkbox-primary" />
                            <span class="label-text text-xs">Ingat Saya</span>
                        </label>
                    </div>

                    <button type="submit" class="btn btn-primary bg-emerald-700 hover:bg-emerald-800 border-none text-white w-full font-bold shadow-lg">
                        Masuk ke Sistem
                    </button>
                </form>

                <!-- Demo Login Fast Picker -->
                <div class="mt-6 pt-4 border-t border-base-200">
                    <p class="text-[11px] font-semibold text-base-content/60 text-center mb-2">Login Cepat Demo (Pengujian):</p>
                    <div class="grid grid-cols-3 gap-2 text-xs">
                        <button type="button" onclick="fillAccount('kepala@tpqannur.com', 'admin123')" class="btn btn-outline btn-xs border-red-600 text-red-800 hover:bg-red-50" title="Kepala TPQ / SuperAdmin">
                            <span class="hidden sm:inline">Kepala TPQ</span>
                            <span class="sm:hidden">Admin</span>
                        </button>
                        <button type="button" onclick="fillAccount('ustadzah.fatimah@tpqannur.com', 'guru123')" class="btn btn-outline btn-xs border-emerald-600 text-emerald-800 hover:bg-emerald-50" title="Ustadzah / Guru">
                            Ustadzah
                        </button>
                        <button type="button" onclick="fillAccount('budi.rahman@gmail.com', 'ortu123')" class="btn btn-outline btn-xs border-teal-600 text-teal-800 hover:bg-teal-50" title="Wali Santri / Orang Tua">
                            <span class="hidden sm:inline">Wali Santri</span>
                            <span class="sm:hidden">Ortu</span>
                        </button>
                    </div>
                    <p class="text-[10px] text-center text-base-content/40 mt-2">
                        💡 Klik tombol di atas untuk mengisi otomatis
                    </p>
                </div>
            </div>
        </div>

        <p class="text-center text-xs text-white/50 mt-6">
            © {{ date('Y') }} TPQ Annur Bogor. All rights reserved.
        </p>
    </div>

    <script>
        function fillAccount(email, pass) {
            document.getElementById('email-field').value = email;
            document.getElementById('password-field').value = pass;
        }
    </script>

    <!-- Alert Popup Component -->
    <x-alert-popup />
</body>
</html>

