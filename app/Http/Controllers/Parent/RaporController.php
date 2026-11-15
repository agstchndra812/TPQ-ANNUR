<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use App\Models\Santri;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class RaporController extends Controller
{
    /**
     * Download or stream child's report card as PDF.
     */
    public function cetakRapor(Santri $santri, Request $request): Response
    {
        $user = Auth::user();
        $orangTua = $user->orangTua;

        // Security check: parent can only access report of their own child
        if (! $orangTua || $santri->orang_tua_id !== $orangTua->id) {
            abort(403, 'Akses ditolak. Anda hanya diizinkan mengunduh rapor anak Anda sendiri.');
        }

        $bulan = (int) $request->query('bulan', Carbon::now()->month);
        $tahun = (int) $request->query('tahun', Carbon::now()->year);

        $santri->load(['orangTua.user']);

        // Presensi in the selected period
        $presensiList = $santri->presensi()
            ->whereYear('tanggal', $tahun)
            ->whereMonth('tanggal', $bulan)
            ->orderBy('tanggal')
            ->get();

        $totalHari = $presensiList->count();
        $totalHadir = $presensiList->where('status', 'Hadir')->count();
        $totalIzin = $presensiList->where('status', 'Izin')->count();
        $totalSakit = $presensiList->where('status', 'Sakit')->count();
        $totalAlpa = $presensiList->where('status', 'Alpa')->count();
        $persentaseHadir = $totalHari > 0 ? round(($totalHadir / $totalHari) * 100, 1) : 0;

        // Setoran Ziyadah
        $setoranZiyadah = $santri->setoranHafalan()
            ->with('surah')
            ->where('jenis', 'ziyadah')
            ->whereYear('tanggal_setoran', $tahun)
            ->whereMonth('tanggal_setoran', $bulan)
            ->orderBy('tanggal_setoran')
            ->get();

        // Setoran Muraja'ah
        $setoranMurajaah = $santri->setoranHafalan()
            ->with('surah')
            ->where('jenis', 'murajaah')
            ->whereYear('tanggal_setoran', $tahun)
            ->whereMonth('tanggal_setoran', $bulan)
            ->orderBy('tanggal_setoran')
            ->get();

        $namaBulan = Carbon::createFromDate($tahun, $bulan, 1)->isoFormat('MMMM Y');

        $data = [
            'santri' => $santri,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'namaBulan' => $namaBulan,
            'presensiList' => $presensiList,
            'totalHari' => $totalHari,
            'totalHadir' => $totalHadir,
            'totalIzin' => $totalIzin,
            'totalSakit' => $totalSakit,
            'totalAlpa' => $totalAlpa,
            'persentaseHadir' => $persentaseHadir,
            'setoranZiyadah' => $setoranZiyadah,
            'setoranMurajaah' => $setoranMurajaah,
            'tanggalCetak' => Carbon::now()->isoFormat('D MMMM Y'),
        ];

        $pdf = Pdf::loadView('pdf.rapor_santri', $data)->setPaper('a4', 'portrait');

        $safeName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $santri->nama_lengkap);
        $filename = "Rapor_{$safeName}_{$bulan}_{$tahun}.pdf";

        return $pdf->stream($filename);
    }
}

