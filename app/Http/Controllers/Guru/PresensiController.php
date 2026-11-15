<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Presensi;
use App\Models\Santri;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PresensiController extends Controller
{
    /**
     * Display presensi form.
     */
    public function index(Request $request): View
    {
        $tanggal = $request->query('tanggal', Carbon::today()->format('Y-m-d'));
        $jilid = $request->query('jilid');

        $santriQuery = Santri::where('status_aktif', true);

        if ($jilid) {
            $santriQuery->where('jilid_kelas', $jilid);
        }

        $santriList = $santriQuery->orderBy('nama_lengkap')->get();

        // Load existing presensi
        $existingPresensi = Presensi::where('tanggal', $tanggal)
            ->whereIn('santri_id', $santriList->pluck('id'))
            ->get()
            ->keyBy('santri_id');

        $daftarJilid = ['Jilid 1', 'Jilid 2', 'Jilid 3', 'Jilid 4', 'Jilid 5', 'Jilid 6', "Al-Qur'an", 'Tahfidz'];

        return view('guru.presensi.index', [
            'santriList' => $santriList,
            'existingPresensi' => $existingPresensi,
            'tanggal' => $tanggal,
            'daftarJilid' => $daftarJilid,
            'selectedJilid' => $jilid,
        ]);
    }

    /**
     * Store or update presensi.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'tanggal' => ['required', 'date'],
            'presensi' => ['required', 'array'],
            'presensi.*.santri_id' => ['required', 'exists:santri,id'],
            'presensi.*.status' => ['required', 'in:Hadir,Izin,Sakit,Alpa'],
        ]);

        foreach ($validated['presensi'] as $item) {
            Presensi::updateOrCreate(
                [
                    'santri_id' => $item['santri_id'],
                    'tanggal' => $validated['tanggal'],
                ],
                [
                    'status' => $item['status'],
                ]
            );
        }

        return redirect()->route('guru.presensi.index', ['tanggal' => $validated['tanggal']])
            ->with('success', 'Data presensi berhasil disimpan.');
    }

    /**
     * Display presensi recap.
     */
    public function rekap(Request $request): View
    {
        $bulan = (int) $request->query('bulan', Carbon::now()->month);
        $tahun = (int) $request->query('tahun', Carbon::now()->year);
        $jilid = $request->query('jilid');

        $santriQuery = Santri::with(['presensi' => function ($q) use ($bulan, $tahun): void {
            $q->whereYear('tanggal', $tahun)
                ->whereMonth('tanggal', $bulan);
        }]);

        if ($jilid) {
            $santriQuery->where('jilid_kelas', $jilid);
        }

        $santriList = $santriQuery->where('status_aktif', true)
            ->orderBy('nama_lengkap')
            ->get();

        $daftarJilid = ['Jilid 1', 'Jilid 2', 'Jilid 3', 'Jilid 4', 'Jilid 5', 'Jilid 6', "Al-Qur'an", 'Tahfidz'];

        return view('guru.presensi.rekap', [
            'santriList' => $santriList,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'daftarJilid' => $daftarJilid,
            'selectedJilid' => $jilid,
        ]);
    }
}
