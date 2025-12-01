<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('disposals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('asset_id');
            $table->date('tarikh');
            $table->string('sebab');
            $table->string('kaedah')->nullable(); // jual/hapus/serah PTG dsb
            $table->string('rujukan_kelulusan')->nullable(); // luar sistem
            $table->timestamps();

            $table->foreign('asset_id')->references('id')->on('assets');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('disposals');
    }
};
