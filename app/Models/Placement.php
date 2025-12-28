<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Placement extends Model
{
    use HasFactory;

     // Simpan rekod penempatan aset
    protected $fillable = [
        'asset_id',
        'user_id',
        'bahagian_id',
        'unit_id',
        'tarikh_mula',
        'tarikh_tamat',
        'aktif',
    ];

    // Aset ditempatkan
    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }

    // Pengguna aset
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Bahagian penempatan
    public function bahagian()
    {
        return $this->belongsTo(Bahagian::class);
    }

    // Unit penempatan
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
