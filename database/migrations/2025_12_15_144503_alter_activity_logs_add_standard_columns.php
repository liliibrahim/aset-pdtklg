<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('activity_logs', function (Blueprint $table) {

            $table->string('aktiviti')->nullable()->after('user_id');
            $table->string('modul')->nullable()->after('aktiviti');

            $table->string('tindakan')->nullable()->after('modul');
            $table->string('aset')->nullable()->after('tindakan');
            $table->string('rekod')->nullable()->after('aset');
        });
    }

    public function down()
    {
        Schema::table('activity_logs', function (Blueprint $table) {
            $table->dropColumn([
                'aktiviti',
                'modul',
                'tindakan',
                'aset',
                'rekod'
            ]);
        });
    }
};
