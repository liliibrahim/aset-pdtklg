<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    // Simpan log aktiviti sistem
    protected $fillable = [
        'user_id',
        'aktiviti',
        'modul',
        'tindakan',
        'aset',
        'rekod',
        'asset_id',   
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }
}
