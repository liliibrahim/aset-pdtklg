<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('assets', function (Blueprint $table) {
        $table->timestamp('created_at')
            ->nullable()
            ->useCurrent()
            ->change();

        $table->timestamp('updated_at')
            ->nullable()
            ->useCurrent()
            ->useCurrentOnUpdate()
            ->change();
    });
}

public function down()
{
    Schema::table('assets', function (Blueprint $table) {
        //
    });
}

};
