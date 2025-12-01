<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserRoleSeeder extends Seeder
{
    public function run(): void
    {
        // Roles
        DB::table('roles')->updateOrInsert(['id' => 1], [
            'name' => 'admin_system',
            'guard_name' => 'web'
        ]);

        DB::table('roles')->updateOrInsert(['id' => 2], [
            'name' => 'ict',
            'guard_name' => 'web'
        ]);

        // Admin user
        $adminId = DB::table('users')->updateOrInsert(
            ['email' => 'admin@selangor.gov.my'],
            [
                'name' => 'Admin Sistem',
                'role' => 'admin_system',
                'password' => Hash::make('password123'),
            ]
        );

        // Pegawai ICT
        $ictId = DB::table('users')->updateOrInsert(
            ['email' => 'ict@selangor.gov.my'],
            [
                'name' => 'Pegawai ICT',
                'role' => 'ict',
                'password' => Hash::make('password123'),
            ]
        );
    }
}
