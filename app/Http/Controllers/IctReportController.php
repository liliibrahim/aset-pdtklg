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
    // Paparan laporan aduan ICT (screen)     
    public function aduan(Request $request)
    {
        $status = $request->input('status');
        $from   = $request->input('from');
        $to     = $request->input('to');

        $query = MaintenanceRequest::with('asset');

        // Filter asas
        $query->when($status, fn ($q) => $q->where('status', $status));
        $query->when($from, fn ($q) => $q->whereDate('created_at', '>=', $from));
        $query->when($to, fn ($q) => $q->whereDate('created_at', '<=', $to));

        // Senarai aduan dengan pagination
        $aduans = $query->latest()
            ->paginate(15)
            ->withQueryString();

        // Ringkasan statistik aduan
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

    // Paparan laporan aset rosak (screen)     
    public function asetRosak(Request $request)
    {
        $bahagian = $request->input('bahagian');
        $unit     = $request->input('unit');

        $query = Asset::where('status', 'rosak');

        // Filter mengikut bahagian dan unit
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

        // Senarai aset rosak dengan pagination
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

    // Paparan laporan aset mengikut usia (screen)    
    public function asetUsang(Request $request)
    {
        $tahap = (int) $request->get('usia'); // 5,7,8
        $tahunSemasa = now()->year;
        
        // Filter aset berdasarkan kategori usia
        $assets = Asset::when($tahap, function ($q) use ($tahap, $tahunSemasa) {

            if ($tahap == 5) {
                $q->whereBetween(
                    DB::raw('YEAR(tarikh_perolehan)'),
                    [$tahunSemasa - 7, $tahunSemasa - 6]
                );
            } elseif ($tahap == 7) {
                $q->whereYear('tarikh_perolehan', $tahunSemasa - 8);
            } elseif ($tahap == 8) {
                $q->whereYear('tarikh_perolehan', '<=', $tahunSemasa - 9);
            }
        })->paginate(20);

        return view('LaporanMain.aset_usang', compact('assets', 'tahap'));
    }

    // Jana laporan aduan ICT (PDF)
    
    public function aduanPdf()
    {
        // Data laporan PDF (tanpa pagination)
        $aduans = MaintenanceRequest::with('asset')
            ->latest()
            ->get();

        $ringkasan = [
            'jumlah' => $aduans->count(),
            'selesai' => $aduans->where('status', 'Selesai')->count(),
            'dalam_proses' => $aduans->where('status', 'Dalam Proses')->count(),
            'baru' => $aduans->where('status', 'Baru')->count(),
        ];

        return Pdf::loadView(
            'LaporanMain.pdf.aduan',
            compact('aduans', 'ringkasan')
        )
        ->setPaper('A4', 'landscape')
        ->stream('Laporan_Aduan_ICT.pdf');
    }

    // Jana laporan aset rosak (PDF)
    public function asetRosakPdf(Request $request)
    {
        // Data laporan PDF
        $assets = Asset::where('status', 'Rosak')->get();
        $jumlahRosak = $assets->count();

        return Pdf::loadView(
            'LaporanMain.pdf.aset_rosak',
            compact('assets', 'jumlahRosak')
        )->setPaper('A4', 'landscape')
        ->stream('laporan-aset-rosak.pdf');
}
 
    // Jana laporan aset usang (PDF)
    public function asetUsangPdf(Request $request)
    {
        $tahap = (int) $request->get('tahap');
        $tahunSemasa = now()->year;

        // Data laporan aset mengikut usia
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

        // Log aktiviti cetakan laporan
        logActivity('Cetak Laporan Aset Usang');

        return Pdf::loadView(
            'LaporanMain.pdf.aset_usang',
            compact('assets', 'tahap')
        )
        ->setPaper('A4', 'landscape')
        ->stream('laporan-aset_usang.pdf');
    }
}
