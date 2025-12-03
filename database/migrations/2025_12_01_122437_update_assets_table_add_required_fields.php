<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('assets', function (Blueprint $table) {

            // Buang field ENUM / string lama
            $drop = [
                'kategori',
                'jenama',
                'pembekal',
                'bahagian',
                'unit',
                'lokasi_lain',
            ];

            foreach ($drop as $col) {
                if (Schema::hasColumn('assets', $col)) {
                    $table->dropColumn($col);
                }
            }

            // Tambah FK baharu
            $table->unsignedBigInteger('kategori_id')->nullable()->after('nama');
            $table->unsignedBigInteger('jenama_id')->nullable()->after('kategori_id');
            $table->unsignedBigInteger('pembekal_id')->nullable()->after('jenama_id');
            $table->unsignedBigInteger('bahagian_id')->nullable()->after('pembekal_id');
            $table->unsignedBigInteger('unit_id')->nullable()->after('bahagian_id');
            $table->unsignedBigInteger('lokasi_id')->nullable()->after('unit_id');

            // Foreign key link
            $table->foreign('kategori_id')->references('id')->on('kategoris')->nullOnDelete();
            $table->foreign('jenama_id')->references('id')->on('jenamas')->nullOnDelete();
            $table->foreign('pembekal_id')->references('id')->on('suppliers')->nullOnDelete();
            $table->foreign('bahagian_id')->references('id')->on('bahagians')->nullOnDelete();
            $table->foreign('unit_id')->references('id')->on('units')->nullOnDelete();
            $table->foreign('lokasi_id')->references('id')->on('placements')->nullOnDelete();
        });
    }

    public function down(): void
    {
        //
    }
};
