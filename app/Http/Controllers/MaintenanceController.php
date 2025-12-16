<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Maintenance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MaintenanceController extends Controller
{
    /**
     * Papar borang aduan
     */
    public function create(Asset $asset)
    {
        $user = Auth::user();

        if (!$user || !$user->bahagian || !$user->unit) {
            abort(403, 'Profil pengguna tidak lengkap');
        }

        if (
            $asset->bahagian !== $user->bahagian->nama ||
            $asset->unit !== $user->unit->nama
        ) {
            abort(403, 'Akses tidak dibenarkan');
        }

        return view('aduan.create', compact('asset'));
    }

    /**
     * Simpan aduan
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'asset_id'    => 'required|exists:assets,id',
            'jenis_aduan' => 'required|string',
            'keterangan'  => 'required|string',
        ]);

        $aduan = Maintenance::create([
            'asset_id' => $validated['asset_id'],
            'user_id'  => Auth::id(),
            'jenis'    => $validated['jenis_aduan'],
            'catatan'  => $validated['keterangan'],
            'status'   => 'Dihantar',
            'tarikh'   => now(),
        ]);

        // ✅ LOG AKTIVITI (HANTAR ADUAN)
        logActivity(
            'Hantar Aduan',
            $aduan->asset_id,
            $aduan->id
        );

        return redirect()->route('user.dashboard')
            ->with('success', 'Aduan kerosakan berjaya dihantar.');
    }

    /**
     * Kemas kini status aduan (ICT)
     */
    public function updateStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|string',
        ]);

        $aduan = Maintenance::findOrFail($id);
        $aduan->status = $validated['status'];
        $aduan->save();

        // LOG AKTIVITI (KEMASKINI ADUAN)
        logActivity(
            'Kemaskini Aduan',
            $aduan->asset_id,
            $aduan->id
        );

        return back()->with('success', 'Status aduan dikemaskini');
    }
}
