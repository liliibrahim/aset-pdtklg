<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Bahagian;
use App\Models\Unit;

class BahagianUnitSeeder extends Seeder
{
    public function run(): void
    {
        $data = [

            // 1
            'Pejabat Pegawai Daerah' => [],

            // 2
            'Unit Perundangan' => [],

            // 3
            'Unit Integriti dan Perlesenan' => [],

            // 4
            'Bahagian Khidmat Pengurusan' => [
                'Unit Pentadbiran Am',
                'Unit ICT',
                'Unit Sumber Manusia',
                'Unit Kewangan',
                'Unit Aset & Stor',
                'Unit Bencana',
                'Unit Majlis dan Keraian',
            ],

            // 5
            'Bahagian Pengurusan Tanah' => [
                'Unit Pelupusan Tanah',
                'Unit Pembangunan Tanah',
                'Unit Hasil',
                'Unit Teknikal & Penguatkuasaan',
                'Unit Pendaftaran',
                'Unit Pindahmilik & Lelong',
            ],

            // 6
            'Bahagian Pembangunan' => [
                'Unit Pembangunan Masyarakat',
                'Unit Pembangunan Fizikal',
            ],
        ];

        foreach ($data as $bahagianName => $units) {

            $bahagian = Bahagian::create(['nama' => $bahagianName]);

            foreach ($units as $unit) {
                Unit::create([
                    'nama'        => $unit,
                    'bahagian_id' => $bahagian->id,
                ]);
            }
        }
    }
}
