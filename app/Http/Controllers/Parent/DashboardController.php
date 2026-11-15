<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use App\Models\Santri;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display parent monitoring dashboard.
     */
    public function index(Request $request): View
    {
        $user = Auth::user();
        $orangTua = $user->orangTua;

        $santriList = $orangTua ? $orangTua->santri : collect();

        $selectedSantriId = $request->query('santri_id');
        /** @var \App\Models\Santri|null $activeSantri */
        $activeSantri = null;

        if ($santriList->isNotEmpty()) {
            if ($selectedSantriId) {
                $activeSantri = $santriList->firstWhere('id', (int) $selectedSantriId);
            }
            if (! $activeSantri) {
                $activeSantri = $santriList->first();
            }
        }

        $bulanSekarang = Carbon::now()->month;
        $tahunSekarang = Carbon::now()->year;

        $stats = [
            'totalZiyadah' => 0,
            'totalMurajaah' => 0,
            'persentaseKehadiran' => 0,
            'totalHadir' => 0,
            'totalIzin' => 0,
            'totalSakit' => 0,
            'totalAlpa' => 0,
            'latestZiyadah' => null,
            'latestMurajaah' => null,
        ];

        $recentSetoran = collect();
        $recentPresensi = collect();

        if ($activeSantri) {
            $stats['totalZiyadah'] = $activeSantri->setoranHafalan()
                ->where('jenis', 'ziyadah')
                ->count();

            $stats['totalMurajaah'] = $activeSantri->setoranHafalan()
                ->where('jenis', 'murajaah')
                ->count();

            $stats['latestZiyadah'] = $activeSantri->setoranHafalan()
                ->with('surah')
                ->where('jenis', 'ziyadah')
                ->latest('tanggal_setoran')
                ->latest('id')
                ->first();

            $stats['latestMurajaah'] = $activeSantri->setoranHafalan()
                ->with('surah')
                ->where('jenis', 'murajaah')
                ->latest('tanggal_setoran')
                ->latest('id')
                ->first();

            // Presensi bulan ini
            $presensiBulanIni = $activeSantri->presensi()
                ->whereYear('tanggal', $tahunSekarang)
                ->whereMonth('tanggal', $bulanSekarang)
                ->get();

            $totalPresensi = $presensiBulanIni->count();
            $stats['totalHadir'] = $presensiBulanIni->where('status', 'Hadir')->count();
            $stats['totalIzin'] = $presensiBulanIni->where('status', 'Izin')->count();
            $stats['totalSakit'] = $presensiBulanIni->where('status', 'Sakit')->count();
            $stats['totalAlpa'] = $presensiBulanIni->where('status', 'Alpa')->count();

            $stats['persentaseKehadiran'] = $totalPresensi > 0
                ? round(($stats['totalHadir'] / $totalPresensi) * 100, 1)
                : 100;

            // Setoran feed
            $recentSetoran = $activeSantri->setoranHafalan()
                ->with('surah')
                ->latest('tanggal_setoran')
                ->latest('id')
                ->take(10)
                ->get();

            // Presensi history
            $recentPresensi = $activeSantri->presensi()
                ->latest('tanggal')
                ->take(15)
                ->get();
        }

        return view('parent.dashboard', [
            'orangTua' => $orangTua,
            'santriList' => $santriList,
            'activeSantri' => $activeSantri,
            'stats' => $stats,
            'recentSetoran' => $recentSetoran,
            'recentPresensi' => $recentPresensi,
            'currentMonthName' => Carbon::now()->isoFormat('MMMM Y'),
            'currentMonth' => $bulanSekarang,
            'currentYear' => $tahunSekarang,
        ]);
    }
}

