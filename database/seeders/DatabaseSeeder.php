<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
   public function run(): void
{
    $this->call([
        BahagianSeeder::class,
        UnitSeeder::class,
        AdminSeeder::class,   // <-- tambah ini
    ]);
}
}
