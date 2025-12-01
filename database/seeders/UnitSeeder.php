<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Unit;

class UnitSeeder extends Seeder
{
    public function run(): void
    {
        $units = [
            4 => [ // Bahagian Khidmat Pengurusan
                'Unit Pentadbiran Am',
                'Unit ICT',
                'Unit Sumber Manusia',
                'Unit Kewangan',
                'Unit Aset & Stor',
                'Unit Bencana',
                'Unit Majlis dan Keraian',
            ],

            5 => [ // Bahagian Pengurusan Tanah
                'Unit Pelupusan Tanah',
                'Unit Pembangunan Tanah',
                'Unit Hasil',
                'Unit Teknikal & Penguatkuasaan',
                'Unit Pendaftaran',
                'Unit Pindahmilik & Lelong',
            ],

            6 => [ // Bahagian Pembangunan
                'Unit Pembangunan Masyarakat',
                'Unit Pembangunan Fizikal',
            ],
        ];

        foreach ($units as $bahagianID => $list) {
            foreach ($list as $nama) {
                Unit::create([
                    'bahagian_id' => $bahagianID,
                    'nama' => $nama
                ]);
            }
        }
    }
}
