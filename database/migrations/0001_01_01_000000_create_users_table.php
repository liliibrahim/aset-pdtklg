<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            // Nama pengguna
            $table->string('name');

            // Emel mesti unique
            $table->string('email')->unique();

            // Kolum role (jika anda mahu simpan role terus dalam table users)
            // Tidak perlu limit panjang kecil, supaya tidak truncate lagi
            $table->string('role', 50)->nullable();

            // Standard Laravel
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');

            // Token remember me
            $table->rememberToken();

            // Rekod masa
            $table->timestamps();

            // Jika mahu save log delete
            // $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
