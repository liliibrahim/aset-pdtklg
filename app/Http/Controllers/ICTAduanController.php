<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\MaintenanceRequest;

class ICTAduanController extends Controller
{

    public function index(Request $request)
    {
        $query = MaintenanceRequest::with(['asset', 'user', 'complaint']);

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $aduans = $query->latest()->paginate(10);

        return view('aduan.index', compact('aduans'));
    }
    public function show(MaintenanceRequest $aduan)
    {
        return view('aduan.show', compact('aduan'));
    }

  
    public function update(Request $request, MaintenanceRequest $aduan)
{
    $request->validate([
        'tindakan_ict' => 'required|string',
    ]);

    // Status sedia ada
    $statusICT  = $aduan->status;
    $statusUser = $aduan->complaint->status;

    /*
    |--------------------------------------------------
    | KAWAL PERUBAHAN STATUS
    |--------------------------------------------------
    | - Aduan kekal 'baru' sehingga tindakan sebenar
    | - Hanya tindakan tertentu menukar status
    */

    // 1️⃣ Jika selesai
    if ($request->tindakan_ict === 'selesai_dibaiki') {

        $statusICT  = 'selesai';
        $statusUser = 'Selesai';
        $aduan->asset->update([
    'status' => 'Aktif'
]);

    }

    // 2️⃣ Jika mula tindakan sebenar
    elseif (
        $aduan->status === 'baru' &&
        in_array($request->tindakan_ict, [
            'pembaikan_sedang_dijalankan',
            'menunggu_alat_ganti',
            'menunggu_vendor',
            'tidak_dapat_dibaiki',
            
        ])
        
    ) $aduan->asset->update([
    'status' => 'Rosak'
]);{

        $statusICT  = 'dalam_tindakan';
        $statusUser = 'Dalam Tindakan';

    }

    // 3️⃣ Selain itu → status KEKAL (contoh: sedang_disemak)

    $aduan->update([
        'tindakan_ict' => $request->tindakan_ict,
        'status'       => $statusICT,
        'ict_id'       => Auth::id(),
    ]);

    $aduan->complaint->update([
        'status' => $statusUser,
    ]);

    return back()->with('success', 'Tindakan aduan berjaya dikemaskini.');
}
}