<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Maintenance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MaintenanceController extends Controller
{
    // Papar borang aduan kerosakan aset
    public function create(Asset $asset)
    {
        $user = Auth::user();

        // Pastikan profil pengguna lengkap
        if (!$user || !$user->bahagian || !$user->unit) {
            abort(403, 'Profil pengguna tidak lengkap');
        }

        // Kawalan akses berdasarkan bahagian dan unit
        if (
            $asset->bahagian !== $user->bahagian->nama ||
            $asset->unit !== $user->unit->nama
        ) {
            abort(403, 'Akses tidak dibenarkan');
        }

        return view('aduan.create', compact('asset'));
    }

    // Simpan aduan kerosakan
    public function store(Request $request)
    {
        // Validasi input aduan
        $validated = $request->validate([
            'asset_id'    => 'required|exists:assets,id',
            'jenis_aduan' => 'required|string',
            'keterangan'  => 'required|string',
        ]);

        // Cipta rekod aduan
        $aduan = Maintenance::create([
            'asset_id' => $validated['asset_id'],
            'user_id'  => Auth::id(),
            'jenis'    => $validated['jenis_aduan'],
            'catatan'  => $validated['keterangan'],
            'status'   => 'Dihantar',
            'tarikh'   => now(),
        ]);

        // Rekod log aktiviti
        logActivity(
            'Hantar Aduan',
            $aduan->asset_id,
            $aduan->id
        );

        return redirect()->route('user.dashboard')
            ->with('success', 'Aduan kerosakan berjaya dihantar.');
    }

    // Kemas kini status aduan oleh ICT
    public function updateStatus(Request $request, $id)
    {
        // Validasi status aduan
        $validated = $request->validate([
            'status' => 'required|string',
        ]);

        $aduan = Maintenance::findOrFail($id);
        $aduan->status = $validated['status'];
        $aduan->save();

        // Rekod log aktiviti
        logActivity(
            'Kemaskini Aduan',
            $aduan->asset_id,
            $aduan->id
        );

        return back()->with('success', 'Status aduan dikemaskini');
    }
}
