<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Asset;
use App\Models\User;
use App\Models\MaintenanceRequest;

class Complaint extends Model
{
    protected $fillable = [
        'asset_id',
        'user_id',
        'tarikh_aduan',
        'jenis_aduan',
        'keterangan',
        'status',
    ];

      public function asset()
    {
        return $this->belongsTo(Asset::class);
    }

     public function user()
    {
        return $this->belongsTo(User::class);
    }

     public function maintenanceRequest()
    {
        return $this->hasOne(MaintenanceRequest::class);
    }
}
