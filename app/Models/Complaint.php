<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Asset;
use App\Models\User;
use App\Models\MaintenanceRequest;

class Complaint extends Model
{
    // Simpan aduan kerosakan
    protected $fillable = [
        'asset_id',
        'user_id',
        'tarikh_aduan',
        'jenis_aduan',
        'keterangan',
        'status',
    ];

    // Aduan berkaitan aset
    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }

    // Aduan dibuat oleh pengguna
     public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Permohonan penyelenggaraan hasil aduan
     public function maintenanceRequest()
    {
        return $this->hasOne(MaintenanceRequest::class);
    }
}
