<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Bahagian; // 👈 WAJIB
use App\Models\Unit;     // 👈 WAJIB

class Lokasi extends Model
{
    protected $fillable = [
        'nama',
        'bahagian_id',
        'unit_id',
        'is_special',
    ];

    public function bahagian()
    {
        return $this->belongsTo(Bahagian::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
