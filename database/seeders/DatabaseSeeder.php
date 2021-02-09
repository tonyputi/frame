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
        // \App\Models\Host::factory(10)->create();
        $this->call(CasinoProvidersSeeder::class);
        // $this->call(LocationSeeder::class);
    }
}
