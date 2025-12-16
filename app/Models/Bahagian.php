<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Unit; 

class Bahagian extends Model
{
    protected $fillable = ['nama'];

    public function units()
    {
        return $this->hasMany(Unit::class, 'bahagian_id');
    }
}
