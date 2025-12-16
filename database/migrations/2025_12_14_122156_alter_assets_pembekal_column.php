<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    public function up()
    {
        Schema::table('assets', function (Blueprint $table) {
            $table->string('pembekal', 255)->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('assets', function (Blueprint $table) {
            $table->string('pembekal', 50)->nullable()->change(); 
            // atau ikut saiz asal awak
        });
    }
};
