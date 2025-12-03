<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('assets', function (Blueprint $table) {

            // Update ENUM bahagian
            $table->enum('bahagian', [
                // Kawasan Pejabat / Unit
                'Pejabat Pegawai Daerah',
                'Unit Perundangan',
                'Unit Integriti dan Perlesenan',

                // Bahagian besar
                'Bahagian Khidmat Pengurusan',
                'Bahagian Pengurusan Tanah',
                'Bahagian Pembangunan',

                // Lokasi sebenar PDT Klang
                'Stor ICT',
                'Stor Dewan',
                'Stor LG',
                'Stor Bilik DDOC',
                'Bilik DDOC',
                'Bilik Gerakan',
                'Auditorium',
            ])->nullable()->change();

            // Update ENUM unit — hanya bagi bahagian yg ada unit
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
            ])->nullable()->change();
        });
    }

    public function down(): void
    {
        // Optional – revert ke ENUM lama jika perlu
    }
};
