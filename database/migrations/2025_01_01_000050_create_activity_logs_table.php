<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::create('activity_logs', function (Blueprint $table) {
        $table->id();
        $table->string('action');
        $table->unsignedBigInteger('user_id');
        $table->unsignedBigInteger('asset_id')->nullable(); // 🔥 WAJIB ADA
        $table->text('description')->nullable();
        $table->timestamps();
    });
}

    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
