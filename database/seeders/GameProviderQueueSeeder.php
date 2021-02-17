<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use App\Models\GameProviderQueue;

class GameProviderQueueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        GameProviderQueue::create([
            'environment_id' => 1,
            'application_id' => 1,
            'game_provider_id' => 1,
            'user_id' => 1,
            'started_at' => Carbon::parse('+1 hour'),
            'ended_at' => Carbon::parse('+2 hour'),
            'applied_at' => Carbon::parse('+1 hour'),
        ]);
    }
}
