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
        $this->call(UserSeeder::class);
        $this->call(EnvironmentSeeder::class);
        $this->call(ApplicationSeeder::class);
        $this->call(GameProviderSeeder::class);
        //$this->call(GameProviderQueueSeeder::class);
    }
}
