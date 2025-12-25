<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Maintenance;
use App\Models\MaintenanceRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
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
     * ===========================
     * DASHBOARD ICT (LOGIK B)
     * ===========================
     */
    public function ict()
    {
        $tahunSemasa = now()->year;

        // ======================
        // KIRAAN ASAS
        // ======================
        $totalAset = Asset::count();
        $digunakan = Asset::where('status', 'Aktif')->count();
        $rosak     = Asset::where('status', 'Rosak')->count();
        $pelupusan = Asset::where('status', 'Untuk Dilupus')->count();

        $tanpaPenempatan = Asset::where(function ($q) {
            $q->whereNull('bahagian')
              ->orWhereNull('unit')
              ->orWhere('bahagian', '')
              ->orWhere('unit', '');
        })->count();

        // ======================
        // LOGIK USIA ASET (B)
        // ======================

        // Akan Usang: 6–7 tahun
        $lebih5 = Asset::whereYear('tarikh_perolehan', '>=', $tahunSemasa - 7)
            ->whereYear('tarikh_perolehan', '<=', $tahunSemasa - 6)
            ->count();

        // Wajar Dinilai Pelupusan: 8 tahun
        $lebih7 = Asset::whereYear('tarikh_perolehan', $tahunSemasa - 8)
            ->count();

        // Disyorkan Ganti Tahun Ini: ≥ 9 tahun
        $lebih8 = Asset::whereYear('tarikh_perolehan', '<=', $tahunSemasa - 9)
            ->count();

        // ======================
        // DATA FILTER (CHART)
        // ======================
        $bahagianLabels = collect([
            'Pejabat Pegawai Daerah',
            'Unit Perundangan',
            'Unit Integriti dan Perlesenan',
            'Bahagian Khidmat Pengurusan',
            'Bahagian Pengurusan Tanah',
            'Bahagian Pembangunan',
            'Stor ICT',
            'Stor Dewan',
            'Stor LG',
            'Stor Bilik DDOC',
            'Bilik DDOC',
            'Bilik Gerakan',
            'Auditorium',
        ]);

        $units = Asset::whereNotNull('unit')
            ->where('unit', '!=', '')
            ->distinct()
            ->pluck('unit');

        $jenamas = Asset::whereNotNull('jenama')
            ->where('jenama', '!=', '')
            ->distinct()
            ->pluck('jenama');

        $pembekals = Asset::whereNotNull('pembekal')
            ->where('pembekal', '!=', '')
            ->distinct()
            ->pluck('pembekal');

        $sumbers = Asset::whereNotNull('sumber_perolehan')
            ->where('sumber_perolehan', '!=', '')
            ->distinct()
            ->pluck('sumber_perolehan');

        $tahunLabels = Asset::selectRaw('YEAR(tarikh_perolehan) as tahun')
            ->whereNotNull('tarikh_perolehan')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        // ======================
        // NOTIFIKASI
        // ======================
        $reminder = Maintenance::where('tarikh', '>=', now())
            ->orderBy('tarikh', 'asc')
            ->first();

        $aduanBaru = MaintenanceRequest::where('status', 'baru')->count();
        $aduanDalamTindakan = MaintenanceRequest::where('status', 'dalam_tindakan')->count();

        return view('dashboard.ict', compact(
            'totalAset',
            'digunakan',
            'rosak',
            'pelupusan',
            'tanpaPenempatan',
            'lebih5',
            'lebih7',
            'lebih8',
            'bahagianLabels',
            'units',
            'jenamas',
            'pembekals',
            'sumbers',
            'tahunLabels',
            'reminder',
            'aduanBaru',
            'aduanDalamTindakan'
        ));
    }

    /**
     * ===========================
     * FILTER CHART AJAX
     * ===========================
     */
    public function filter(Request $request)
    {
        $query = Asset::query();

        if ($request->bahagian) $query->where('bahagian', $request->bahagian);
        if ($request->unit) $query->where('unit', $request->unit);
        if ($request->tahun) $query->whereYear('tarikh_perolehan', $request->tahun);
        if ($request->jenama) $query->where('jenama', $request->jenama);
        if ($request->pembekal) $query->where('pembekal', $request->pembekal);
        if ($request->sumber) $query->where('sumber_perolehan', $request->sumber);

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
     * ===========================
     * DASHBOARD PENGGUNA
     * ===========================
     */
    public function user()
{
    $user = Auth::user();

    // Keselamatan: pastikan profil lengkap
    if (
        !$user ||
        !$user->bahagian ||
        !$user->unit ||
        empty($user->bahagian->nama) ||
        empty($user->unit->nama)
    ) {
        abort(403, 'Profil pengguna tidak lengkap');
    }

// Query aset di bawah tanggungjawab pengguna (ikut user_id)
$asetQuery = Asset::where('user_id', $user->id)
    ->with(['complaints.maintenanceRequest']);

    // Statistik (dikira di DB – lebih efisien)
    $totalAset = (clone $asetQuery)->count();

    $asetAktif = (clone $asetQuery)
        ->where('status', 'Aktif')
        ->count();

    $asetRosak = (clone $asetQuery)
        ->where('status', 'Rosak')
        ->count();

    // Senarai aset
    $asetSaya = $asetQuery->get();

    return view('dashboard.user', compact(
        'asetSaya',
        'totalAset',
        'asetAktif',
        'asetRosak'
    ));
}
    /**
     * ===========================
     * API UNIT BY BAHAGIAN
     * ===========================
     */
    public function getUnitsByBahagian(Request $request)
    {
        $mapping = [
            'Bahagian Khidmat Pengurusan' => [
                'Unit Pentadbiran Am',
                'Unit ICT',
                'Unit Sumber Manusia',
                'Unit Kewangan',
                'Unit Aset & Stor',
                'Unit Bencana',
                'Unit Majlis dan Keraian',
            ],
            'Bahagian Pengurusan Tanah' => [
                'Unit Pelupusan Tanah',
                'Unit Pembangunan Tanah',
                'Unit Hasil',
                'Unit Teknikal & Penguatkuasaan',
                'Unit Pendaftaran',
                'Unit Pindahmilik & Lelong',
            ],
            'Bahagian Pembangunan' => [
                'Unit Pembangunan Masyarakat',
                'Unit Pembangunan Fizikal',
            ],
        ];

        return response()->json($mapping[$request->bahagian] ?? []);
    }
}
