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
       Schema::create('maintenance_requests', function (Blueprint $table) {
    $table->id();

    $table->foreignId('asset_id')->constrained()->cascadeOnDelete();
    $table->foreignId('user_id')->constrained()->cascadeOnDelete();

    $table->string('jenis_aduan');
    $table->text('keterangan')->nullable();

    $table->enum('status', ['baru', 'dalam_tindakan', 'selesai', 'ditolak'])
          ->default('baru');

    $table->text('catatan_ict')->nullable();
    $table->foreignId('ict_id')->nullable()->references('id')->on('users');

    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
