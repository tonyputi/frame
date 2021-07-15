<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Booking;
use App\Models\Location;
use Carbon\CarbonInterval;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 1. take users in random order
        // 2. for each user:
        //    1. take one environment in random order
        //    2. take on location in random order form the given environment
        //    3. check the last ended_at booking for the given provider and create new one based on it

        for($i = 0; $i < 24; $i++) {
            $user = User::inRandomOrder()->firstOrFail();

            Booking::factory()->create([
                'location_id' => Location::inRandomOrder()->firstOrFail()->id,
                'performed_by' => $user->id,
                'user_id' => $user->id
            ]);
        }
    }
}
