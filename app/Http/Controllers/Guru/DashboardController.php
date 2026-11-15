<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Presensi;
use App\Models\Santri;
use App\Models\SetoranHafalan;
use Carbon\Carbon;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display Guru dashboard.
     */
    public function index(): View
    {
        $today = Carbon::today();

        $stats = [
            'total_santri' => Santri::where('status_aktif', true)->count(),
            'presensi_hari_ini' => Presensi::whereDate('tanggal', $today)->count(),
            'setoran_hari_ini' => SetoranHafalan::whereDate('tanggal_setoran', $today)->count(),
            'presensi_bulan_ini' => Presensi::whereMonth('tanggal', $today->month)
                ->whereYear('tanggal', $today->year)
                ->count(),
        ];

        return view('guru.dashboard', compact('stats'));
    }
}
