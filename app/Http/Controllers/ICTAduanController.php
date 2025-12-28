<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\User;
use App\Models\Unit;

class ICTAduanController extends Controller
{
    /**
     * Senarai aduan kerosakan untuk operasi ICT
     * (paparan skrin dengan fungsi carian dan filter).
     */
    public function index(Request $request)
    {
        $status = $request->get('status');

        $statusMap = [
            'baru'           => 'Menunggu Tindakan ICT',
            'dalam_tindakan' => 'Dalam Tindakan',
            'selesai'        => 'Selesai',
        ];

        $query = Complaint::with(['asset', 'user']);

        // Filter status aduan
        if ($status && isset($statusMap[$status])) {
            $query->where('status', $statusMap[$status]);
        }

        // Filter pengadu
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // Filter unit melalui pengguna
        if ($request->filled('unit_id')) {
        $query->whereHas('user', function ($q) use ($request) {
            $q->where('unit_id', $request->unit_id);
        });
    }

        // Filter tarikh aduan
        if ($request->filled('tarikh_dari') && $request->filled('tarikh_hingga')) {
            $query->whereBetween('tarikh_aduan', [
                $request->tarikh_dari,
                $request->tarikh_hingga
            ]);
        }

        // Filter aset (no siri)
        if ($request->filled('aset')) {
            $query->whereHas('asset', function ($q) use ($request) {
                $q->where('no_siri', 'like', '%' . $request->aset . '%');
            });
        }

        $aduans = $query
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        // Data sokongan dropdown
        $users = User::orderBy('name')->get();
        $units = Unit::orderBy('nama')->get();

        return view('aduan.index', compact('aduans', 'status', 'users', 'units'));
    }

    /**
    * Kemas kini tindakan ICT dan status aduan.
    */
    public function update(Request $request, Complaint $aduan)
    {
        $request->validate([
            'tindakan_ict' => 'required|string',
        ]);

        // Penentuan status baharu aduan dan aset
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
     * Paparan laporan aduan (skrin).
     */
    public function laporan(Request $request)
    {
        $query = Complaint::with(['asset', 'user']);

        // Filter status aduan
        if ($request->filled('status')) {
            $statusMap = [
                'baru' => 'Menunggu Tindakan ICT',
                'dalam_tindakan' => 'Dalam Tindakan',
                'selesai' => 'Selesai',
            ];
            $query->where('status', $statusMap[$request->status]);
        }

        // Filter pengadu, unit, jenis aduan dan tarikh
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('unit_id')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('unit_id', $request->unit_id);
            });
        }

        if ($request->filled('jenis_aduan')) {
            $query->where('jenis_aduan', $request->jenis_aduan);
            }

        if ($request->filled('tarikh_dari') && $request->filled('tarikh_hingga')) {
            $query->whereBetween('tarikh_aduan', [
                $request->tarikh_dari,
                $request->tarikh_hingga
            ]);
        }
        
        if ($request->filled('aset')) {
            $query->whereHas('asset', function ($q) use ($request) {
                $q->where('no_siri', 'like', '%' . $request->aset . '%');
            });
        }

        $aduans = $query
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        // Ringkasan statistik aduan
        $ringkasan = [
            'jumlah' => $aduans->total(),
            'baru' => Complaint::where('status', 'Menunggu Tindakan ICT')->count(),
            'dalam_tindakan' => Complaint::where('status', 'Dalam Tindakan')->count(),
            'selesai' => Complaint::where('status', 'Selesai')->count(),
        ];

        $users = User::orderBy('name')->get();
        $units = Unit::orderBy('nama')->get();

        return view(
            'LaporanMain.aduan',
            compact('aduans', 'ringkasan', 'users', 'units')
        );
    }

    /**
    * Menjana laporan aduan ICT dalam format PDF.
    */
    public function laporanPdf(Request $request)
    {
        $query = Complaint::with(['asset', 'user']);

        // Filter laporan PDF
        if ($request->filled('status')) {
            $statusMap = [
                'baru' => 'Menunggu Tindakan ICT',
                'dalam_tindakan' => 'Dalam Tindakan',
                'selesai' => 'Selesai',
            ];
            $query->where('status', $statusMap[$request->status]);
        }

        if ($request->filled('jenis_aduan')) {
            $query->where('jenis_aduan', $request->jenis_aduan);
        }

        if ($request->filled('tarikh_dari') && $request->filled('tarikh_hingga')) {
            $query->whereBetween('tarikh_aduan', [
                $request->tarikh_dari,
                $request->tarikh_hingga
            ]);
        }
        
        if ($request->filled('aset')) {
            $query->whereHas('asset', function ($q) use ($request) {
                $q->where('no_siri', 'like', '%' . $request->aset . '%');
            });
        }

    
    // Data untuk laporan PDF (tanpa pagination)
    $aduans = $query
        ->orderBy('created_at', 'desc')
        ->get();

    // Ringkasan statistik aduan
        $ringkasan = [
        'jumlah' => $aduans->count(),
        'baru'   => $aduans->where('status', 'Menunggu Tindakan ICT')->count(),
        'dalam_tindakan' => $aduans->where('status', 'Dalam Tindakan')->count(),
        'selesai' => $aduans->where('status', 'Selesai')->count(),
    ];

    // Jana dan paparkan laporan PDF aduan
    return Pdf::loadView(
        'LaporanMain.pdf.aduan',
        compact('aduans', 'ringkasan')
    )
    ->setPaper('a4', 'landscape')
    ->stream('laporan-aduan-ict.pdf');
}

}
