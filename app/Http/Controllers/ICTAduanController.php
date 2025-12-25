<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class ICTAduanController extends Controller
{
    /**
     * =====================================================
     * SENARAI ADUAN (OPERASI ICT)
     * URL: /ict/aduan
     * =====================================================
     */
    public function index(Request $request)
    {
        $status = $request->get('status');

        // Mapping status UI → DB
        $statusMap = [
            'baru'            => 'Menunggu Tindakan ICT',
            'dalam_tindakan'  => 'Dalam Tindakan',
            'selesai'         => 'Selesai',
        ];

        $aduans = Complaint::with(['asset', 'user'])
            ->when($status && isset($statusMap[$status]), function ($q) use ($status, $statusMap) {
                $q->where('status', $statusMap[$status]);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('aduan.index', compact('aduans', 'status'));
    }

    /**
     * =====================================================
     * KEMASKINI TINDAKAN ICT
     * =====================================================
     */
    public function update(Request $request, Complaint $aduan)
    {
        $request->validate([
            'tindakan_ict' => 'required|string',
        ]);

        if ($request->tindakan_ict === 'selesai_dibaiki') {
            $statusBaru = 'Selesai';

            $aduan->asset?->update([
                'status' => 'Aktif',
            ]);
        } else {
            $statusBaru = 'Dalam Tindakan';

            $aduan->asset?->update([
                'status' => 'Rosak',
            ]);
        }

        $aduan->update([
            'tindakan_ict' => $request->tindakan_ict,
            'status'       => $statusBaru,
            'ict_id'       => Auth::id(),
        ]);

        return back()->with('success', 'Tindakan aduan berjaya dikemaskini.');
    }

    /**
     * =====================================================
     * LAPORAN ADUAN (SCREEN)
     * URL: /ict/laporan/aduan
     * =====================================================
     */
    public function laporan(Request $request)
{
    $ringkasan = [
        'jumlah' => Complaint::count(),
        'baru'   => Complaint::where('status', 'Menunggu Tindakan ICT')->count(),
        'dalam_tindakan' => Complaint::where('status', 'Dalam Tindakan')->count(),
        'selesai' => Complaint::where('status', 'Selesai')->count(),
    ];

    $aduans = Complaint::with('asset')
        ->orderBy('created_at', 'desc')
        ->paginate(10);

    return view('LaporanMain.aduan', compact('aduans', 'ringkasan'));
}

    /**
     * =====================================================
     * LAPORAN ADUAN (PDF)
     * =====================================================
     */
    public function laporanPdf(Request $request)
    {
        $aduans = Complaint::with('asset')
            ->orderBy('created_at', 'desc')
            ->get();

        $pdf = Pdf::loadView('LaporanMain.pdf.aduan', compact('aduans'))
            ->setPaper('a4', 'landscape');

        return $pdf->stream('laporan-aduan-ict.pdf');
    }
}
