<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Asset; // 👈 WAJIB TAMBAH

class Disposal extends Model
{
    use HasFactory;

    protected $fillable = [
        'asset_id',
        'tarikh',
        'sebab',
        'kaedah',
        'rujukan_kelulusan',
    ];

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }
}
