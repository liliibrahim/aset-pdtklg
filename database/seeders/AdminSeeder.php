<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@selangor.gov.my'],  // admin tetap
            [
                'name'        => 'Pentadbir Sistem',
                'email'       => 'admin@selangor.gov.my',
                'password'    => Hash::make('Admin123!'), // boleh tukar
                'phone'       => '0123456789',
                'bahagian_id' => 1,  // default, boleh tukar
                'unit_id'     => 1,  // default, boleh tukar
                'role'        => 'admin'
            ]
        );
    }
}
