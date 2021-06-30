<?php

namespace Database\Seeders;

use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::where('is_admin', true)->firstOrFail();
        $users = User::where('is_admin', false)->get();

        $paradoxical = Team::factory()->create([
            'name' => 'Paradoxical',
            'personal_team' => false,
            'user_id' => $admin->id
        ]);

        $paradoxical->users()->sync($users);

        $admin->switchTeam($paradoxical);
        $users->each(fn($user) => $user->switchTeam($paradoxical));
    }
}
