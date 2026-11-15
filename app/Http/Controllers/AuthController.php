<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
    /**
     * Show login form.
     */
    public function showLoginForm(): View|RedirectResponse
    {
        if (Auth::check()) {
            if (Auth::user()->isSuperAdmin()) {
                return redirect()->route('superadmin.dashboard');
            }

            if (Auth::user()->isGuru()) {
                return redirect()->route('guru.dashboard');
            }

            return redirect()->route('parent.dashboard');
        }

        return view('auth.login');
    }

    /**
     * Handle login authentication.
     */
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            if (Auth::user()->isSuperAdmin()) {
                return redirect()->intended(route('superadmin.dashboard'))
                    ->with('success', 'Selamat datang kembali, '.Auth::user()->name);
            }

            if (Auth::user()->isGuru()) {
                return redirect()->intended(route('guru.dashboard'))
                    ->with('success', 'Selamat datang kembali, '.Auth::user()->name);
            }

            return redirect()->intended(route('parent.dashboard'))
                ->with('success', 'Selamat datang di Portal Wali Santri, '.Auth::user()->name);
        }

        return back()->withErrors([
            'email' => 'Email atau kata sandi yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    /**
     * Handle user logout.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda telah berhasil keluar dari sistem.');
    }
}

