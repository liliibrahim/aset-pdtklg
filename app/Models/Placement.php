<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Placement extends Model
{
    use HasFactory;

    protected $fillable = [
        'asset_id',
        'user_id',
        'bahagian_id',
        'unit_id',
        'tarikh_mula',
        'tarikh_tamat',
        'aktif',
    ];

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bahagian()
    {
        return $this->belongsTo(Bahagian::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
