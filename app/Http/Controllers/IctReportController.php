<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\MaintenanceRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class IctReportController extends Controller
{
    /**
     * =====================================================
     * LAPORAN ADUAN ICT (SCREEN)
     * =====================================================
     */
    public function aduan(Request $request)
    {
        $status = $request->input('status');
        $from   = $request->input('from');
        $to     = $request->input('to');

        $query = MaintenanceRequest::with('asset');

        $query->when($status, fn ($q) => $q->where('status', $status));
        $query->when($from, fn ($q) => $q->whereDate('created_at', '>=', $from));
        $query->when($to, fn ($q) => $q->whereDate('created_at', '<=', $to));

        $aduans = $query->latest()
            ->paginate(15)
            ->withQueryString();

        $ringkasan = MaintenanceRequest::selectRaw("
                SUM(status = 'baru') AS baru,
                SUM(status = 'dalam_tindakan') AS dalam_tindakan,
                SUM(status = 'selesai') AS selesai,
                COUNT(*) AS jumlah
            ")
            ->first()
            ->toArray();

        return view('LaporanMain.aduan', compact(
            'aduans',
            'ringkasan',
            'status',
            'from',
            'to'
        ));
    }

    /**
     * =====================================================
     * LAPORAN ASET ROSAK (SCREEN)
     * =====================================================
     */
    public function asetRosak(Request $request)
    {
        $bahagian = $request->input('bahagian');
        $unit     = $request->input('unit');

        $query = Asset::where('status', 'rosak');

        $query->when($bahagian, fn ($q) => $q->where('bahagian', $bahagian));
        $query->when($unit, fn ($q) => $q->where('unit', $unit));

        $bahagianList = Asset::whereNotNull('bahagian')
            ->where('bahagian', '!=', '')
            ->distinct()
            ->orderBy('bahagian')
            ->pluck('bahagian');

        $unitList = Asset::whereNotNull('unit')
            ->where('unit', '!=', '')
            ->distinct()
            ->orderBy('unit')
            ->pluck('unit');

        $jumlahRosak = Asset::where('status', 'rosak')->count();

        $assets = $query->orderBy('bahagian')
            ->orderBy('unit')
            ->paginate(15)
            ->withQueryString();

        return view('LaporanMain.aset_rosak', compact(
            'assets',
            'jumlahRosak',
            'bahagianList',
            'unitList',
            'bahagian',
            'unit'
        ));
    }

    /**
     * =====================================================
     * LAPORAN ASET MENGIKUT USIA (SCREEN)
     * LOGIK B (TIDAK BERTINDIH)
     * =====================================================
     */
    public function asetUsang(Request $request)
    {
        $tahap = (int) $request->get('usia'); // 5,7,8
        $tahunSemasa = now()->year;

        $assets = Asset::when($tahap, function ($q) use ($tahap, $tahunSemasa) {

            if ($tahap == 5) {
                // Akan Usang: 6–7 tahun
                $q->whereBetween(
                    DB::raw('YEAR(tarikh_perolehan)'),
                    [$tahunSemasa - 7, $tahunSemasa - 6]
                );
            } elseif ($tahap == 7) {
                // Wajar Dinilai Pelupusan: 8 tahun
                $q->whereYear('tarikh_perolehan', $tahunSemasa - 8);
            } elseif ($tahap == 8) {
                // Disyorkan Ganti Tahun Ini: ≥ 9 tahun
                $q->whereYear('tarikh_perolehan', '<=', $tahunSemasa - 9);
            }
        })->paginate(20);

        return view('LaporanMain.aset_usang', compact('assets', 'tahap'));
    }

    /**
     * =====================================================
     * PDF LAPORAN ADUAN ICT
     * =====================================================
     */
    public function aduanPdf()
    {
        $aduans = MaintenanceRequest::with('asset')
            ->latest()
            ->get();

        return Pdf::loadView('LaporanMain.pdf.aduan', compact('aduans'))
            ->setPaper('A4', 'landscape')
            ->stream('Laporan_Aduan_ICT.pdf');
    }

    /**
     * =====================================================
     * PDF LAPORAN ASET ROSAK
     * =====================================================
     */
    public function asetRosakPdf()
    {
        $assets = Asset::where('status', 'rosak')->get();
        $jumlahRosak = $assets->count();

        return Pdf::loadView(
            'LaporanMain.pdf.aset_rosak',
            compact('assets', 'jumlahRosak')
        )
        ->setPaper('A4', 'landscape')
        ->stream('Laporan_Aset_Rosak.pdf');
    }

    /**
     * =====================================================
     * PDF LAPORAN ASET MENGIKUT USIA (LOGIK B)
     * =====================================================
     */
    public function asetUsangPdf(Request $request)
    {
        $tahap = (int) $request->get('tahap');
        $tahunSemasa = now()->year;

        $assets = Asset::when($tahap, function ($q) use ($tahap, $tahunSemasa) {

            if ($tahap === 5) {
                $q->whereBetween(
                    DB::raw('YEAR(tarikh_perolehan)'),
                    [$tahunSemasa - 7, $tahunSemasa - 6]
                );
            }

            if ($tahap === 7) {
                $q->whereYear('tarikh_perolehan', $tahunSemasa - 8);
            }

            if ($tahap === 8) {
                $q->whereYear('tarikh_perolehan', '<=', $tahunSemasa - 9);
            }
        })->get();

        // LOG AKTIVITI
        logActivity('Cetak Laporan Aset Usang');

        return Pdf::loadView(
            'LaporanMain.pdf.aset_usang',
            compact('assets', 'tahap')
        )
        ->setPaper('A4', 'landscape')
        ->stream('laporan-aset_usang.pdf');
    }
}
