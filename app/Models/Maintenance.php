<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Maintenance extends Model
{
    use HasFactory;

    protected $fillable = [
        'asset_id',
        'tarikh',
        'jenis_kerja',
        'kos',
        'catatan',
        'pembekal_id'
    ];

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }

    public function pembekal()
    {
        return $this->belongsTo(Supplier::class, 'pembekal_id');
    }
}
