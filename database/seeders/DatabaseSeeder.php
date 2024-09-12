<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Panggil seeder lainnya di sini jika ada
        $this->call(AdminSeeder::class); // Panggil AdminSeeder di sini
    }
}
