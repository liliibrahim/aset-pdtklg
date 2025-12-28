<?php

namespace App\Http\Controllers;

use App\Models\MaintenanceRequest;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    /**
     * Paparan laporan aduan (screen)
     */
    public function aduan()
    {
        // Ringkasan statistik aduan
        $ringkasan = [
            'jumlah' => MaintenanceRequest::count(),
            'baru' => MaintenanceRequest::where('status', 'baru')->count(),
            'dalam_tindakan' => MaintenanceRequest::where('status', 'dalam_tindakan')->count(),
            'selesai' => MaintenanceRequest::where('status', 'selesai')->count(),
        ];

        // Senarai aduan dengan pagination
        $aduans = MaintenanceRequest::latest()->paginate(10);

        return view('LaporanMain.aduan', compact(
            'ringkasan',
            'aduans'
        ));
    }
}
