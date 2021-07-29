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
            'name' => 'Filippo Sallemi',
            'email' => 'filippo.sallemi@example.com',
            'hostname' => 'filippo.example.com',
            'password' => Hash::make('12345678'),
            'options' => [
            ]
        ]);

        User::factory()->create([
            'name' => 'Sandro Basta',
            'email' => 'sandro.basta@example.com',
            'hostname' => 'sandro.example.com',
            'password' => Hash::make('12345678')
        ]);
    }
}
