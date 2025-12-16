<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Asset;
use App\Models\User;
use App\Models\Complaint;

class MaintenanceRequest extends Model
{
    protected $fillable = [
        'complaint_id',
        'asset_id',
        'user_id',
        'status',
        'tindakan_ict',
        'catatan_ict',
        'ict_id',
    ];

     public function complaint()
    {
        return $this->belongsTo(Complaint::class);
    }

     public function asset()
    {
        return $this->belongsTo(Asset::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ict()
    {
        return $this->belongsTo(User::class, 'ict_id');
    }
}
