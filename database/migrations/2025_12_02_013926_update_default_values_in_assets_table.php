<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('assets', function (Blueprint $table) {

            // Nama pengguna — jadikan default "-"
            $table->string('nama_pengguna')
                ->nullable()
                ->default('-')
                ->change();

            // Bahagian — ENUM baru ikut form + default "-"
            $table->enum('bahagian', [
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
                'Auditorium',

                '-' // fallback option
            ])
            ->nullable()
            ->default('-')
            ->change();

            // Unit — ENUM baru ikut form + default "-"
            $table->enum('unit', [
                'Unit Pentadbiran Am',
                'Unit ICT',
                'Unit Sumber Manusia',
                'Unit Kewangan',
                'Unit Aset & Stor',
                'Unit Bencana',
                'Unit Majlis dan Keraian',

                'Unit Pelupusan Tanah',
                'Unit Pembangunan Tanah',
                'Unit Hasil',
                'Unit Teknikal & Penguatkuasaan',
                'Unit Pendaftaran',
                'Unit Pindahmilik & Lelong',

                'Unit Pembangunan Masyarakat',
                'Unit Pembangunan Fizikal',

                '-' // fallback option
            ])
            ->nullable()
            ->default('-')
            ->change();
        });
    }

    public function down(): void
    {
        // OPTIONAL — biar kosong kalau tak nak revert
    }
};
