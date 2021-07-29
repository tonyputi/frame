<?php

namespace Database\Seeders;

use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create([
            'name' => 'Ricardo Ruiz',
            'email' => 'ricardo.ruiz@videoslots.com',
            'hostname' => 'ricardo.videoslots.com',
            'password' => Hash::make('12345678'),
            'is_admin' => true
        ]);

        User::factory()->create([
            'name' => 'Nicky Bartolo',
            'email' => 'nicky.bartolo@videoslots.com',
            'hostname' => 'nicky.videoslots.com',
            'password' => Hash::make('12345678'),
            'is_admin' => true
        ]);

        User::factory()->create([
            'name' => 'Filippo Sallemi',
            'email' => 'filippo.sallemi@videoslots.com',
            'hostname' => 'filippo.videoslots.com',
            'password' => Hash::make('12345678'),
            'options' => [
            ]
        ]);

        User::factory()->create([
            'name' => 'Sandro Basta',
            'email' => 'sandro.basta@videoslots.com',
            'hostname' => 'sandro.videoslots.com',
            'password' => Hash::make('12345678')
        ]);

        User::factory()->create([
            'name' => 'Antonio Blazquez',
            'email' => 'antonio.blazquez@videoslots.com',
            'hostname' => 'antonio.videoslots.com',
            'password' => Hash::make('12345678')
        ]);

        User::factory()->create([
            'name' => 'Marc Powell Evans',
            'email' => 'marc.powell@videoslots.com',
            'hostname' => 'marc.videoslots.com',
            'password' => Hash::make('12345678')
        ]);
    }
}
