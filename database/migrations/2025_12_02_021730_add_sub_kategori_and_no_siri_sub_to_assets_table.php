<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('assets', function (Blueprint $table) {
            $table->string('sub_kategori')->nullable()->after('kategori');
            $table->string('no_siri_sub')->nullable()->after('no_siri');
        });
    }

    public function down(): void
    {
        Schema::table('assets', function (Blueprint $table) {
            $table->dropColumn('sub_kategori');
            $table->dropColumn('no_siri_sub');
        });
    }
};
