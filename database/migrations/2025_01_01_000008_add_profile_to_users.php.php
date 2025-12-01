<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone', 20)->nullable();
            $table->unsignedBigInteger('bahagian_id')->nullable();
            $table->unsignedBigInteger('unit_id')->nullable();
            

            $table->foreign('bahagian_id')->references('id')->on('bahagians');
            $table->foreign('unit_id')->references('id')->on('units');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['bahagian_id']);
            $table->dropForeign(['unit_id']);
            $table->dropColumn(['phone', 'bahagian_id', 'unit_id', 'role']);
        });
    }
};
