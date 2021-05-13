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
            'domain' => 'ittest.videoslots.com',
            'middleware' => 'proxy',
            'prefix' => null,
            'default_redirect_to' => 'it.videoslots.com',
        ]);

        Environment::factory()->create([
            'name' => 'vs-wsdev18',
            'domain' => 'vs-wsdev18.videoslots.com',
            'middleware' => 'proxy',
            'prefix' => null
        ]);
    }
}
