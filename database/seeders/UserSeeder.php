<?php

namespace Database\Seeders;

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
        User::factory()->withPersonalTeam()->create([
            'name' => 'Ricardo Ruiz',
            'email' => 'ricardo.ruiz@videoslots.com',
            'hostname' => 'ricardo.videoslots.com',
            'password' => Hash::make('12345678'),
            'is_admin' => true
        ]);

        User::factory()->withPersonalTeam()->create([
            'name' => 'Nicky Bartolo',
            'email' => 'nicky.bartolo@videoslots.com',
            'hostname' => 'nikcy.videoslots.com',
            'password' => Hash::make('12345678'),
            'is_admin' => true
        ]);

        $leader = User::factory()->withPersonalTeam()->create([
            'name' => 'Goran Misogovich',
            'email' => 'goran.misogovich@videoslots.com',
            'hostname' => 'goran.videoslots.com',
            'password' => Hash::make('12345678')
        ]);

        $team = $leader->ownedTeams()->first();

        $leader->switchTeam($team);

        $user = User::factory()->create([
            'name' => 'Filippo Sallemi',
            'email' => 'filippo.sallemi@videoslots.com',
            'hostname' => 'filippo.videoslots.com',
            'password' => Hash::make('12345678'),
            'is_admin' => true
        ]);
        $user->teams()->attach($team, ['role' => 'editor']);
        $user->switchTeam($team);

        $user = User::factory()->create([
            'name' => 'Marc Powell Evans',
            'email' => 'marc.powell@videoslots.com',
            'hostname' => 'marc.videoslots.com',
            'password' => Hash::make('12345678')
        ]);
        $user->teams()->attach($team, ['role' => 'editor']);
        $user->switchTeam($team);

        $user = User::factory()->create([
            'name' => 'Sandro Basta',
            'email' => 'sandro.basta@videoslots.com',
            'hostname' => 'sandro.videoslots.com',
            'password' => Hash::make('12345678')
        ]);
        $user->teams()->attach($team, ['role' => 'editor']);
        $user->switchTeam($team);
    }
}
