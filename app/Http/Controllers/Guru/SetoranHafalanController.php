<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Santri;
use App\Models\SetoranHafalan;
use App\Models\Surah;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class SetoranHafalanController extends Controller
{
    /**
     * Display listing of setoran hafalan.
     */
    public function index(Request $request): View
    {
        $search = $request->query('search');
        $jenis = $request->query('jenis');
        $santriId = $request->query('santri_id');

        $query = SetoranHafalan::with(['santri', 'surah']);

        if ($search) {
            $query->whereHas('santri', function ($q) use ($search): void {
                $q->where('nama_lengkap', 'like', "%{$search}%");
            });
        }

        if ($jenis) {
            $query->where('jenis', $jenis);
        }

        if ($santriId) {
            $query->where('santri_id', $santriId);
        }

        $setoranList = $query->latest('tanggal_setoran')->paginate(15)->withQueryString();

        $santriList = Santri::where('status_aktif', true)->orderBy('nama_lengkap')->get();

        return view('guru.setoran.index', [
            'setoranList' => $setoranList,
            'santriList' => $santriList,
            'search' => $search,
            'selectedJenis' => $jenis,
            'selectedSantri' => $santriId,
        ]);
    }

    /**
     * Show form for creating setoran.
     */
    public function create(): View
    {
        $santriList = Santri::where('status_aktif', true)->orderBy('nama_lengkap')->get();
        $surahList = Surah::orderBy('nomor_surah')->get();

        return view('guru.setoran.create', [
            'santriList' => $santriList,
            'surahList' => $surahList,
        ]);
    }

    /**
     * Store newly created setoran.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'santri_id' => ['required', 'exists:santri,id'],
            'surah_id' => ['required', 'exists:surah,id'],
            'jenis' => ['required', Rule::in(['ziyadah', 'murajaah'])],
            'ayat_mulai' => ['nullable', 'integer', 'min:1'],
            'ayat_selesai' => ['nullable', 'integer', 'min:1'],
            'tanggal_setoran' => ['required', 'date'],
            'nilai' => ['required', Rule::in(['Mumtaz', 'Jayyid', 'Mengulang'])],
            'catatan' => ['nullable', 'string', 'max:500'],
        ]);

        SetoranHafalan::create($validated);

        return redirect()->route('guru.setoran.index')
            ->with('success', 'Data setoran hafalan berhasil ditambahkan.');
    }

    /**
     * Show form for editing setoran.
     */
    public function edit(SetoranHafalan $setoran): View
    {
        $santriList = Santri::where('status_aktif', true)->orderBy('nama_lengkap')->get();
        $surahList = Surah::orderBy('nomor_surah')->get();

        $setoran->load(['santri', 'surah']);

        return view('guru.setoran.edit', [
            'setoran' => $setoran,
            'santriList' => $santriList,
            'surahList' => $surahList,
        ]);
    }

    /**
     * Update specified setoran.
     */
    public function update(Request $request, SetoranHafalan $setoran): RedirectResponse
    {
        $validated = $request->validate([
            'santri_id' => ['required', 'exists:santri,id'],
            'surah_id' => ['required', 'exists:surah,id'],
            'jenis' => ['required', Rule::in(['ziyadah', 'murajaah'])],
            'ayat_mulai' => ['nullable', 'integer', 'min:1'],
            'ayat_selesai' => ['nullable', 'integer', 'min:1'],
            'tanggal_setoran' => ['required', 'date'],
            'nilai' => ['required', Rule::in(['Mumtaz', 'Jayyid', 'Mengulang'])],
            'catatan' => ['nullable', 'string', 'max:500'],
        ]);

        $setoran->update($validated);

        return redirect()->route('guru.setoran.index')
            ->with('success', 'Data setoran hafalan berhasil diperbarui.');
    }

    /**
     * Remove specified setoran.
     */
    public function destroy(SetoranHafalan $setoran): RedirectResponse
    {
        $setoran->delete();

        return redirect()->route('guru.setoran.index')
            ->with('success', 'Data setoran hafalan berhasil dihapus.');
    }
}
