<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\AssetMovement; 

class Asset extends Model
{
    use HasFactory;

    protected $table = 'assets';

    protected $fillable = [
        // Maklumat Aset ICT
        'no_siri_aset',
        'kategori',
        'sub_kategori',
        'jenama',
        'model',
        'no_siri',
        'no_siri_sub',

        // Perolehan
        'tarikh_perolehan',
        'harga',
        'sumber_perolehan',
        'pembekal',

        // Penempatan (Terkini)
        'bahagian',
        'unit',
        'lokasi_lain',
        'nama_pengguna',
        'tarikh_penempatan',

        // Pelupusan
        'tarikh_pelupusan',
        'rujukan_pelupusan',

        // Status
        'status',

        // Lain-lain
        'catatan',
    ];

    protected $casts = [
        'tarikh_penempatan' => 'date',
        'tarikh_pelupusan' => 'date',
        'tarikh_perolehan'  => 'date',
        'harga'            => 'decimal:2',
    ];

    /**
     * Relationship: Asset mempunyai banyak Rekod Movement
     */
    public function movements()
    {
        return $this->hasMany(AssetMovement::class);
    }

    /**
 * Rekod penempatan semasa (latest movement tanpa tarikh tamat)
 */
public function currentMovement()
{
    return $this->hasOne(AssetMovement::class)
                ->whereNull('tarikh_tamat')
                ->latestOfMany('tarikh_mula'); // ambil tarikh_mula paling baru
}
}
