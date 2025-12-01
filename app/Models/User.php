<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'bahagian_id',
        'unit_id',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
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
