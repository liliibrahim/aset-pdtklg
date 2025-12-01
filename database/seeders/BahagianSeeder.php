<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Bahagian;

class BahagianSeeder extends Seeder
{
    public function run(): void
    {
        $bahagians = [
            'Pejabat Pegawai Daerah',
            'Unit Perundangan',
            'Unit Integriti dan Perlesenan',
            'Bahagian Khidmat Pengurusan',
            'Bahagian Pengurusan Tanah',
            'Bahagian Pembangunan',
            'Stor ICT',
            'Stor Dewan',
            'Stor LG',
            'Stor Bilik DDOC',
            'Bilik DDOC',
            'Bilik Gerakan',
            'Auditorium'
        ];

        foreach ($bahagians as $b) {
            Bahagian::create(['nama' => $b]);
        }
    }
}
