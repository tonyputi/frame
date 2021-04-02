<?php

namespace Database\Seeders;

use App\Models\Environment;
use Illuminate\Database\Seeder;

class EnvironmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Environment::factory()->create([
            'name' => 'Stage IT',
            'domain' => 'it.videoslots.com',
            'middleware' => 'proxy',
            'prefix' => null
        ]);
    }
}
