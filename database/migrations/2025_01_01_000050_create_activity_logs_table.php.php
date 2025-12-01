<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('action');            // create_asset, update_asset, delete_asset, etc
            $table->string('module');            // assets, maintenance, disposal, suppliers
            $table->unsignedBigInteger('record_id')->nullable();
            $table->json('payload')->nullable(); // data ringkas
            $table->ipAddress('ip')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
