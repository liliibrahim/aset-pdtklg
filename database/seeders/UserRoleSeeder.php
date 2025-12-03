<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserRoleSeeder extends Seeder
{
    public function run(): void
    {
        // ADMIN
        DB::table('users')->updateOrInsert(
            ['email' => 'admin@selangor.gov.my'],
            [
                'name' => 'Admin Sistem',
                'role' => 'admin',
                'password' => Hash::make('password123'),
            ]
        );

        // ICT
        DB::table('users')->updateOrInsert(
            ['email' => 'ict@selangor.gov.my'],
            [
                'name' => 'Pegawai ICT',
                'role' => 'ict',
                'password' => Hash::make('password123'),
            ]
        );
    }
}
