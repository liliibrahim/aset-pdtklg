<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Complaint;
use App\Models\MaintenanceRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ComplaintController extends Controller
{
 
    /**
     * Papar borang aduan kerosakan bagi aset tertentu.
     * Akses hanya dibenarkan jika aset milik bahagian dan unit pengguna.
     */
    public function create(Asset $asset)
    {
        $user = Auth::user();

        // Kawalan akses berdasarkan bahagian dan unit
        if (
            $asset->bahagian !== $user->bahagian->nama ||
            $asset->unit !== $user->unit->nama
        ) {
            abort(403, 'Akses tidak dibenarkan');
        }

        return view('aduan.create', compact('asset'));
    }

    /**
     * Simpan aduan kerosakan aset.
     */
    public function store(Request $request)
    {
        // Validasi input aduan
        $request->validate([
            'asset_id'    => 'required|exists:assets,id',
            'jenis_aduan' => 'required|string',
            'keterangan'  => 'required|string',
        ]);

        // Semak aduan sedia ada yang masih dalam tindakan
        $aduanSediaAda = Complaint::where('asset_id', $request->asset_id)
        ->whereIn('status', ['Baru','Dalam Tindakan',])
        ->exists();

        if ($aduanSediaAda) {
            return redirect()
                ->route('user.dashboard')
                ->with('error', 'Aduan untuk aset ini telah dibuat dan masih dalam tindakan.');
        }

        // Cipta rekod aduan
        $complaint = Complaint::create([
            'asset_id'     => $request->asset_id,
            'user_id'      => Auth::id(),
            'tarikh_aduan' => now(),
            'jenis_aduan'  => $request->jenis_aduan,
            'keterangan'   => $request->keterangan,
            'status'       => 'baru',
        ]);

        // Cipta rekod permohonan penyelenggaraan
        MaintenanceRequest::create([
            'complaint_id' => $complaint->id,
            'asset_id'     => $complaint->asset_id,
            'user_id'      => $complaint->user_id,
            'status'       => 'baru',
        ]);

        return redirect()
            ->route('user.dashboard')
            ->with('success', 'Aduan kerosakan berjaya dihantar.');
    }
}
