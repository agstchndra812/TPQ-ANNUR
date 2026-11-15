<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class GuruController extends Controller
{
    /**
     * Display listing of guru.
     */
    public function index(Request $request): View
    {
        $search = $request->query('search');

        $query = User::where('role', 'guru');

        if ($search) {
            $query->where(function ($q) use ($search): void {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $guruList = $query->latest('id')->paginate(10)->withQueryString();

        return view('superadmin.guru.index', [
            'guruList' => $guruList,
            'search' => $search,
        ]);
    }

    /**
     * Show form for creating a new guru.
     */
    public function create(): View
    {
        return view('superadmin.guru.create');
    }

    /**
     * Store newly created guru.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6'],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'guru',
        ]);

        return redirect()->route('superadmin.guru.index')
            ->with('success', 'Akun Guru berhasil dibuat.');
    }

    /**
     * Show form for editing guru.
     */
    public function edit(User $guru): View
    {
        return view('superadmin.guru.edit', [
            'guru' => $guru,
        ]);
    }

    /**
     * Update specified guru.
     */
    public function update(Request $request, User $guru): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($guru->id)],
            'password' => ['nullable', 'string', 'min:6'],
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $guru->update($data);

        return redirect()->route('superadmin.guru.index')
            ->with('success', 'Data Guru '.$request->name.' berhasil diperbarui.');
    }

    /**
     * Remove specified guru.
     */
    public function destroy(User $guru): RedirectResponse
    {
        $name = $guru->name;
        $guru->delete();

        return redirect()->route('superadmin.guru.index')
            ->with('success', 'Akun Guru '.$name.' berhasil dihapus.');
    }
}
