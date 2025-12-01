<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('placements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('asset_id');
            $table->unsignedBigInteger('user_id')->nullable(); // penerima / pemilik
            $table->unsignedBigInteger('bahagian_id')->nullable();
            $table->unsignedBigInteger('unit_id')->nullable();
            $table->date('tarikh_mula');
            $table->date('tarikh_tamat')->nullable();
            $table->boolean('aktif')->default(true);
            $table->timestamps();

            $table->foreign('asset_id')->references('id')->on('assets');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('placements');
    }
};
