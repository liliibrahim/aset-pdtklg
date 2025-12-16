<?php

use App\Models\ActivityLog;
use App\Models\Asset;
use Illuminate\Support\Facades\Auth;

if (! function_exists('logActivity')) {

    function logActivity(string $tindakan, ?int $assetId = null): void
    {
        try {
            $user = Auth::user();

            if (! $user) {
                return;
            }

            $aktiviti = 'Kemaskini';
            $modul    = $assetId ? 'Aset' : 'Sistem';
            $asetNo   = null;
            $rekod    = null;

            if (str_contains($tindakan, 'Tambah')) {
                $aktiviti = 'Tambah';
            } elseif (str_contains($tindakan, 'Padam')) {
                $aktiviti = 'Padam';
            }

            if ($assetId) {
                $asset  = Asset::find($assetId);
                $asetNo = $asset?->no_siri;
                $rekod  = 'ID Aset: ' . $assetId;
            }

            ActivityLog::create([
                'user_id'  => $user->id,
                'aktiviti' => $aktiviti,
                'modul'    => $modul,
                'tindakan' => $tindakan,
                'aset'     => $asetNo,
                'rekod'    => $rekod,
                'asset_id' => $assetId,
            ]);

        } catch (\Throwable $e) {
            logger()->error('logActivity error: ' . $e->getMessage());
        }
    }
}
