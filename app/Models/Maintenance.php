<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Maintenance extends Model
{
    use HasFactory;

    // Simpan rekod penyelenggaraan aset
    protected $fillable = [
        'asset_id',
        'tarikh',
        'jenis_kerja',
        'kos',
        'catatan',
        'pembekal_id'
    ];

    // Penyelenggaraan berkaitan aset
    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }

    // Pembekal yang melaksanakan kerja
    public function pembekal()
    {
        return $this->belongsTo(Supplier::class, 'pembekal_id');
    }
}
