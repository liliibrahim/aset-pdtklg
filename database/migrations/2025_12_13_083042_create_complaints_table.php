<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('asset_id');
            $table->unsignedBigInteger('user_id');

            $table->dateTime('tarikh_aduan');
            $table->string('jenis_aduan');
            $table->text('keterangan');

            $table->string('status')->default('Dihantar');

            $table->timestamps();

           
            $table->foreign('asset_id')->references('id')->on('assets')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('complaints');
    }
    
};
