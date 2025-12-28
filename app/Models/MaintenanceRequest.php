<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Asset;
use App\Models\User;
use App\Models\Complaint;

class MaintenanceRequest extends Model
{
    // Simpan tindakan ICT bagi aduan
    protected $fillable = [
        'complaint_id',
        'asset_id',
        'user_id',
        'status',
        'tindakan_ict',
        'catatan_ict',
        'ict_id',
    ];

    // Permohonan hasil aduan
     public function complaint()
    {
        return $this->belongsTo(Complaint::class);
    }

    // Aset terlibat
     public function asset()
    {
        return $this->belongsTo(Asset::class);
    }

    // Pengadu
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Pegawai ICT yang bertindak
    public function ict()
    {
        return $this->belongsTo(User::class, 'ict_id');
    }
}
