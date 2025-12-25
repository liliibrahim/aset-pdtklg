<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Asset;

/**
 * @property \Carbon\Carbon|null $tarikh_mula
 * @property \Carbon\Carbon|null $tarikh_tamat
 */
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

    protected $casts = [
        'tarikh_mula'  => 'datetime',
        'tarikh_tamat' => 'datetime',
    ];

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }

    public function getTarikhMulaFormattedAttribute()
    {
        return $this->tarikh_mula
            ? $this->tarikh_mula->format('d.m.Y')
            : '-';
    }

    public function getTarikhTamatFormattedAttribute()
    {
        return $this->tarikh_tamat
            ? $this->tarikh_tamat->format('d.m.Y')
            : '-';
    }
}
