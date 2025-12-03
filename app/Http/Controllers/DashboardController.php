<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Maintenance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Dashboard Admin
     */
    public function admin()
    {
        return view('dashboard.admin', [
            'totalAset'   => Asset::count(),
            'rosak'       => Asset::where('status', 'Rosak')->count(),
            'hampirLupus' => Asset::where('status', 'Untuk Dilupus')->count(),
            'recentAsets' => Asset::latest()->take(10)->get(),
        ]);
    }

    /**
     * Dashboard ICT (MAIN DASHBOARD)
     */
    public function ict()
    {
        // ================= STATISTIK RINGKAS =================
        $totalAset = Asset::count();
        $digunakan = Asset::where('status', 'Aktif')->count();
        $rosak     = Asset::where('status', 'Rosak')->count();
        $pelupusan = Asset::where('status', 'Untuk Dilupus')->count();

        $tanpaPenempatan = Asset::where(function ($q) {
            $q->whereNull('bahagian')->orWhere('bahagian', '');
        })->count();

        // ================= AI AGING PREDICTION =================
        $lebih5 = Asset::whereYear('tarikh_perolehan', '<=', now()->subYears(5))->count();
        $lebih7 = Asset::whereYear('tarikh_perolehan', '<=', now()->subYears(7))->count();
        $lebih8 = Asset::whereYear('tarikh_perolehan', '<=', now()->subYears(8))->count();

        // ================= DROPDOWN FILTER DATA =================
        $bahagianLabels = Asset::select('bahagian')->distinct()->pluck('bahagian');
        $units          = Asset::select('unit')->distinct()->pluck('unit');
        $jenamas        = Asset::select('jenama')->distinct()->pluck('jenama');
        $pembekals      = Asset::select('pembekal')->distinct()->pluck('pembekal');
        $sumbers        = Asset::select('sumber_perolehan')->distinct()->pluck('sumber_perolehan');
        $tahunLabels    = Asset::selectRaw('YEAR(tarikh_perolehan) as tahun')
                              ->distinct()
                              ->orderBy('tahun')
                              ->pluck('tahun');

        // ================= REMINDER MAINTENANCE =================
        $reminder = Maintenance::orderBy('tarikh', 'asc')
            ->where('tarikh', '>=', now())
            ->first();

        return view('dashboard.ict', compact(
            'totalAset',
            'digunakan',
            'rosak',
            'pelupusan',
            'tanpaPenempatan',
            'lebih5', 'lebih7', 'lebih8',
            'bahagianLabels',
            'units',
            'jenamas',
            'pembekals',
            'sumbers',
            'tahunLabels',
            'reminder'
        ));
    }

    /**
     * LIVE FILTER – UNTUK MAIN CHART
     */
public function filter(Request $request)
{
    $query = Asset::query();

    // APPLY FILTERS
    if ($request->bahagian) {
        $query->where('bahagian', $request->bahagian);
    }

    if ($request->unit) {
        $query->where('unit', $request->unit);
    }

    if ($request->tahun) {
        $query->whereYear('tarikh_perolehan', $request->tahun);
    }

    if ($request->jenama) {
        $query->where('jenama', $request->jenama);
    }

    if ($request->pembekal) {
        $query->where('pembekal', $request->pembekal);
    }

    if ($request->sumber) {
        $query->where('sumber_perolehan', $request->sumber);
    }

    /*
    |--------------------------------------------------------------------------
    | CHART: GROUP MENGIKUT KATEGORI
    |--------------------------------------------------------------------------
    | Sebab field 'kategori' wujud dan sentiasa ada data.
    | Chart akan tunjuk berapa aset dalam setiap kategori berdasarkan filter.
    |--------------------------------------------------------------------------
    */

    $result = $query->selectRaw('kategori as label, COUNT(*) as jumlah')
                    ->groupBy('kategori')
                    ->orderBy('kategori')
                    ->get();

    return response()->json([
        'labels' => $result->pluck('label'),
        'counts' => $result->pluck('jumlah'),
    ]);
}

    /**
     * Dashboard User
     */
    public function user()
    {
        $user = Auth::user();
        $asetSaya = Asset::where('assigned_to', $user->id)->get();

        return view('dashboard.user', [
            'asetSaya' => $asetSaya
        ]);
    }
}
