<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Asset;   

class AssetMovement extends Model
{
    protected $table = 'asset_movements';

    protected $fillable = [
        'asset_id',
        'bahagian',
        'unit',
        'nama_pengguna',
        'tarikh_mula',
        'tarikh_tamat',
        'catatan',
    ];

    protected $dates = [
        'tarikh_mula',
        'tarikh_tamat'
    ];

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }
}
