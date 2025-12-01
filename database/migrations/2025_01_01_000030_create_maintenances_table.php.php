<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('maintenances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('asset_id');
            $table->date('tarikh');
            $table->string('jenis_kerja');
            $table->decimal('kos', 12, 2)->nullable();
            $table->text('catatan')->nullable();
            $table->unsignedBigInteger('pembekal_id')->nullable();
            $table->timestamps();

            $table->foreign('asset_id')->references('id')->on('assets');
            $table->foreign('pembekal_id')->references('id')->on('suppliers');
            $table->unique(['asset_id', 'tarikh']); // cegah duplikasi (asset, tarikh)
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('maintenances');
    }
};
