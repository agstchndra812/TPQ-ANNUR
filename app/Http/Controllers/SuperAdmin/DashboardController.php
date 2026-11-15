<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\OrangTua;
use App\Models\Santri;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display SuperAdmin dashboard.
     */
    public function index(): View
    {
        $stats = [
            'total_santri' => Santri::count(),
            'santri_aktif' => Santri::where('status_aktif', true)->count(),
            'total_orang_tua' => OrangTua::count(),
            'total_guru' => User::where('role', 'guru')->count(),
        ];

        return view('superadmin.dashboard', compact('stats'));
    }
}
