<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $fillable = ['nama', 'bahagian_id'];

    public function bahagian()
    {
        return $this->belongsTo(Bahagian::class, 'bahagian_id');
    }
}
