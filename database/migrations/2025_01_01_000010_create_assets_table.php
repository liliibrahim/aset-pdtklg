<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->id();

            // ========= MAKLUMAT ASET ICT =========
            $table->string('no_peralatan')->unique();      
            $table->string('no_aset_dalaman')->nullable(); 
            $table->string('nama');                           
            $table->string('kategori')->nullable();            // Komputer, Printer, Switch dll
            $table->string('jenama')->nullable();             
            $table->string('model')->nullable();              
            $table->string('no_siri')->nullable();            
            $table->year('tahun_perolehan')->nullable();      
            $table->decimal('harga', 12, 2)->nullable();      

            // ========= SUMBER PEROLEHAN =========
            $table->enum('sumber_perolehan', [
                'Pejabat SUK Selangor',
                'Pejabat Tanah Galian Selangor',
                'Perolehan Jabatan',
                'Jabatan Ketua Pengarah Tanah dan Galian Persekutuan',
                'Sumbangan'
            ]);

            // ========= PEMBEKAL =========
            $table->enum('pembekal', [
                'GLOBAL ELITE',
                'S.I.PROTECT',
                'KONSORTIUM JAYA SDN. BHD',
                'BSO TECHNOLOGIES SDN. BHD.',
                'TELITI COMPUTERS SDN. BHD.',
                'SINAR RKK',
                'MAGECOM SOLUTION',
                'HAYNIK',
                'SUNDATA'
            ])->nullable();

            // ========= PENEMPATAN =========
            $table->enum('bahagian', [
                'Pejabat Pegawai Daerah',
                'Unit Perundangan',
                'Unit Integriti dan Perlesenan',
                'Bahagian Khidmat Pengurusan',
                'Bahagian Pengurusan Tanah',
                'Bahagian Pembangunan',
                'Lain-lain'
            ])->nullable();

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
                'Unit Pembangunan Fizikal'
            ])->nullable();

            $table->enum('lokasi_lain', [
                'Stor ICT',
                'Stor Dewan',
                'Stor LG',
                'Stor Bilik DDOC',
                'Bilik DDOC',
                'Bilik',
                'Gerakan',
                'Auditorium'
            ])->nullable();

            $table->string('nama_pengguna')->nullable();

            // ========= STATUS =========
            $table->enum('status', [
                'Aktif',
                'Rosak',
                'Untuk Dilupus',
                'Dilupus'
            ])->default('Aktif');

            // ========= TARIKH TAMBAHAN =========
            $table->date('tarikh_penempatan')->nullable();
            $table->date('tarikh_pelupusan')->nullable();
            $table->string('rujukan_pelupusan')->nullable();

            // ========= CATATAN =========
            $table->text('catatan')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};
