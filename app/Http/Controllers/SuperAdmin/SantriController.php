<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\OrangTua;
use App\Models\Santri;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class SantriController extends Controller
{
    /**
     * Display a listing of santri.
     */
    public function index(Request $request): View
    {
        $search = $request->query('search');
        $jilid = $request->query('jilid');
        $status = $request->query('status');

        $query = Santri::with('orangTua.user');

        if ($search) {
            $query->where(function ($q) use ($search): void {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                    ->orWhere('nis', 'like', "%{$search}%");
            });
        }

        if ($jilid) {
            $query->where('jilid_kelas', $jilid);
        }

        if ($status !== null && $status !== '') {
            $query->where('status_aktif', $status === '1');
        }

        $santriList = $query->orderBy('nama_lengkap')->paginate(10)->withQueryString();

        $daftarJilid = ['Jilid 1', 'Jilid 2', 'Jilid 3', 'Jilid 4', 'Jilid 5', 'Jilid 6', "Al-Qur'an", 'Tahfidz'];

        return view('superadmin.santri.index', [
            'santriList' => $santriList,
            'daftarJilid' => $daftarJilid,
            'search' => $search,
            'selectedJilid' => $jilid,
            'selectedStatus' => $status,
        ]);
    }

    /**
     * Show form for creating a new santri.
     */
    public function create(): View
    {
        $orangTuaList = OrangTua::with('user')->get();
        $daftarJilid = ['Jilid 1', 'Jilid 2', 'Jilid 3', 'Jilid 4', 'Jilid 5', 'Jilid 6', "Al-Qur'an", 'Tahfidz'];

        return view('superadmin.santri.create', [
            'orangTuaList' => $orangTuaList,
            'daftarJilid' => $daftarJilid,
        ]);
    }

    /**
     * Store a newly created santri in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nis' => ['required', 'string', 'max:50', 'unique:santri,nis'],
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'jenis_kelamin' => ['required', Rule::in(['L', 'P'])],
            'tempat_lahir' => ['nullable', 'string', 'max:100'],
            'tanggal_lahir' => ['nullable', 'date'],
            'jilid_kelas' => ['required', 'string', 'max:50'],
            'orang_tua_id' => ['nullable', 'exists:orang_tua,id'],
            'status_aktif' => ['nullable', 'boolean'],
        ]);

        $validated['status_aktif'] = $request->boolean('status_aktif', true);

        Santri::create($validated);

        return redirect()->route('superadmin.santri.index')
            ->with('success', 'Data santri '.$validated['nama_lengkap'].' berhasil ditambahkan.');
    }

    /**
     * Show form for editing santri.
     */
    public function edit(Santri $santri): View
    {
        $orangTuaList = OrangTua::with('user')->get();
        $daftarJilid = ['Jilid 1', 'Jilid 2', 'Jilid 3', 'Jilid 4', 'Jilid 5', 'Jilid 6', "Al-Qur'an", 'Tahfidz'];

        return view('superadmin.santri.edit', [
            'santri' => $santri,
            'orangTuaList' => $orangTuaList,
            'daftarJilid' => $daftarJilid,
        ]);
    }

    /**
     * Update specified santri in storage.
     */
    public function update(Request $request, Santri $santri): RedirectResponse
    {
        $validated = $request->validate([
            'nis' => ['required', 'string', 'max:50', Rule::unique('santri', 'nis')->ignore($santri->id)],
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'jenis_kelamin' => ['required', Rule::in(['L', 'P'])],
            'tempat_lahir' => ['nullable', 'string', 'max:100'],
            'tanggal_lahir' => ['nullable', 'date'],
            'jilid_kelas' => ['required', 'string', 'max:50'],
            'orang_tua_id' => ['nullable', 'exists:orang_tua,id'],
            'status_aktif' => ['nullable', 'boolean'],
        ]);

        $validated['status_aktif'] = $request->boolean('status_aktif');

        $santri->update($validated);

        return redirect()->route('superadmin.santri.index')
            ->with('success', 'Data santri '.$santri->nama_lengkap.' berhasil diperbarui.');
    }

    /**
     * Remove specified santri from storage.
     */
    public function destroy(Santri $santri): RedirectResponse
    {
        $nama = $santri->nama_lengkap;
        $santri->delete();

        return redirect()->route('superadmin.santri.index')
            ->with('success', 'Data santri '.$nama.' berhasil dihapus.');
    }
}
