<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\OrangTua;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class OrangTuaController extends Controller
{
    /**
     * Display listing of orang tua.
     */
    public function index(Request $request): View
    {
        $search = $request->query('search');

        $query = OrangTua::with(['user', 'santri']);

        if ($search) {
            $query->whereHas('user', function ($q) use ($search): void {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            })->orWhere('no_hp', 'like', "%{$search}%")
              ->orWhere('alamat', 'like', "%{$search}%");
        }

        $orangTuaList = $query->latest('id')->paginate(10)->withQueryString();

        return view('superadmin.orang_tua.index', [
            'orangTuaList' => $orangTuaList,
            'search' => $search,
        ]);
    }

    /**
     * Show form for creating a new orang tua.
     */
    public function create(): View
    {
        return view('superadmin.orang_tua.create');
    }

    /**
     * Store newly created orang tua.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6'],
            'no_hp' => ['nullable', 'string', 'max:25'],
            'alamat' => ['nullable', 'string', 'max:500'],
        ]);

        DB::transaction(function () use ($request): void {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'parent',
            ]);

            OrangTua::create([
                'user_id' => $user->id,
                'no_hp' => $request->no_hp,
                'alamat' => $request->alamat,
            ]);
        });

        return redirect()->route('superadmin.orang_tua.index')
            ->with('success', 'Data Orang Tua & akun login berhasil dibuat.');
    }

    /**
     * Show form for editing orang tua.
     */
    public function edit(OrangTua $orangTua): View
    {
        $orangTua->load('user');

        return view('superadmin.orang_tua.edit', [
            'orangTua' => $orangTua,
        ]);
    }

    /**
     * Update specified orang tua.
     */
    public function update(Request $request, OrangTua $orangTua): RedirectResponse
    {
        $user = $orangTua->user;

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:6'],
            'no_hp' => ['nullable', 'string', 'max:25'],
            'alamat' => ['nullable', 'string', 'max:500'],
        ]);

        DB::transaction(function () use ($request, $orangTua, $user): void {
            $userData = [
                'name' => $request->name,
                'email' => $request->email,
            ];

            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }

            $user->update($userData);

            $orangTua->update([
                'no_hp' => $request->no_hp,
                'alamat' => $request->alamat,
            ]);
        });

        return redirect()->route('superadmin.orang_tua.index')
            ->with('success', 'Data Orang Tua '.$request->name.' berhasil diperbarui.');
    }

    /**
     * Remove specified orang tua.
     */
    public function destroy(OrangTua $orangTua): RedirectResponse
    {
        $user = $orangTua->user;
        $name = $user->name ?? 'Orang Tua';

        DB::transaction(function () use ($orangTua, $user): void {
            $orangTua->delete();
            if ($user) {
                $user->delete();
            }
        });

        return redirect()->route('superadmin.orang_tua.index')
            ->with('success', 'Data '.$name.' berhasil dihapus.');
    }
}
