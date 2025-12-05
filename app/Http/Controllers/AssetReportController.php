<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class AssetReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /* LAPORAN A – SATU ASET (KEWPA BAHAGIAN A) */
    public function laporanA($id)
    {
        $asset = Asset::findOrFail($id);

        $pdf = Pdf::loadView('laporan.laporanA', compact('asset'))
                  ->setPaper('A4', 'portrait');

        return $pdf->stream("Laporan_A_{$asset->id}.pdf");
    }

    /* LAPORAN B – SATU ASET (NAIK TARAF / KOMPONEN) */
    public function laporanB($id)
    {
        $asset = Asset::findOrFail($id);

        // kalau ada jadual komponen sendiri, tukar ikut model awak
        $komponen = []; // buat kosong dulu, nanti boleh sambung

        $pdf = Pdf::loadView('laporan.laporanB', compact('asset', 'komponen'))
                  ->setPaper('A4', 'landscape');

        return $pdf->stream("Laporan_B_{$asset->id}.pdf");
    }

    /* LAPORAN C – SENARAI ASET IKUT FILTER */
    public function laporanSenarai(Request $request)
    {
        $query = Asset::query();

        // SAMAKAN FILTER DENGAN AssetController@index
        if ($request->q) {
            $query->where(function ($q) use ($request) {
                $q->where('no_siri', 'like', "%{$request->q}%")
                  ->orWhere('jenama', 'like', "%{$request->q}%")
                  ->orWhere('model', 'like', "%{$request->q}%")
                  ->orWhere('nama_pengguna', 'like', "%{$request->q}%");
            });
        }

        if ($request->kategori) $query->where('kategori', $request->kategori);
        if ($request->bahagian) $query->where('bahagian', $request->bahagian);
        if ($request->unit)     $query->where('unit', $request->unit);

        $assets = $query->orderBy('kategori')->orderBy('bahagian')->get();

        $pdf = Pdf::loadView('laporan.laporanSenarai', [
                    'assets'   => $assets,
                    'request'  => $request, // untuk papar tajuk filter dalam PDF
                ])
                ->setPaper('A4', 'landscape');

        return $pdf->stream('Laporan_Senarai_Aset.pdf');
    }
}
