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
            'name' => gethostname(),
            'domain' => gethostname() . '.videoslots.com',
            'middleware' => 'proxy',
            'prefix' => null,
            'default_redirect_to' => 'filippo.videoslots.com'
        ]);
    }
}
