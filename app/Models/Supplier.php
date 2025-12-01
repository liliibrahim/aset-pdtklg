<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'no_telefon',
        'emel',
        'alamat',
        'aktif'
    ];

    public function assets()
    {
        return $this->hasMany(Asset::class, 'pembekal_id');
    }
}
