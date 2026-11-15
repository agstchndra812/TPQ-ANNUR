<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Surah;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SurahController extends Controller
{
    /**
     * Display listing of 114 Surahs.
     */
    public function index(Request $request): View
    {
        $search = $request->query('search');
        $juz = $request->query('juz');

        $query = Surah::query();

        if ($search) {
            $query->where(function ($q) use ($search): void {
                $q->where('nama_surah', 'like', "%{$search}%")
                    ->orWhere('nomor_surah', $search);
            });
        }

        if ($juz) {
            $query->where('juz', $juz);
        }

        $surahs = $query->orderBy('nomor_surah')->paginate(20)->withQueryString();

        return view('superadmin.surah.index', [
            'surahs' => $surahs,
            'search' => $search,
            'selectedJuz' => $juz,
        ]);
    }
}
