<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Asset extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_peralatan',
        'no_aset_dalaman',
        'nama',
        'jenama',
        'model',
        'kategori',
        'tahun_perolehan',
        'harga',
        'sumber',
        'pembekal_id',
        'status',
    ];

    public function pembekal()
    {
        return $this->belongsTo(Supplier::class, 'pembekal_id');
    }

    public function placements()
    {
        return $this->hasMany(Placement::class);
    }

    public function activePlacement()
    {
        return $this->hasOne(Placement::class)->where('aktif', true);
    }

    public function maintenances()
    {
        return $this->hasMany(Maintenance::class);
    }

    public function disposal()
    {
        return $this->hasOne(Disposal::class);
    }
}
