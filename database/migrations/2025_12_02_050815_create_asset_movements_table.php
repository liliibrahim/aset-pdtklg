<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('asset_movements', function (Blueprint $table) {
        $table->id();
        $table->foreignId('asset_id')->constrained('assets')->onDelete('cascade');
        $table->string('bahagian')->nullable();
        $table->string('unit')->nullable();
        $table->string('nama_pengguna')->nullable();
        $table->date('tarikh_mula')->nullable();
        $table->date('tarikh_tamat')->nullable();
        $table->text('catatan')->nullable();
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asset_movements');
    }
};
