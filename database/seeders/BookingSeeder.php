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
        // $intervals = CarbonInterval::minutes(5)->toPeriod(0, 23);
        // $period = CarbonPeriod::create('today', '1 hour', 'tomorrow');
        // foreach($period as $key => $span) {
        //    dump($key, $span->format('H:i:s'));
        // }

        // 1. take users in random order
        // 2. for each user:
        //    1. take one environment in random order
        //    2. take on location in random order form the given environment
        //    3. check the last ended_at booking for the given provider and create new one based on it

        for($i = 0; $i < 24; $i++) {
            $user = User::inRandomOrder()->firstOrFail();

            $booking = Booking::create([
                'location_id' => Location::firstOrFail()->id,
                'performed_by' => $user->id,
                'user_id' => $user->id,
                'started_at' => Carbon::now()->startOfMinute(),
                'ended_at' => Carbon::now()->endOfHour(),
            ]);

            $user = User::inRandomOrder()->firstOrFail();

            $booking = Booking::create([
                'location_id' => Location::firstOrFail()->id,
                'performed_by' => $user->id,
                'user_id' => $user->id,
                'started_at' => Carbon::parse($booking->ended_at)->addSecond(),
                'ended_at' => Carbon::parse($booking->ended_at)->addMinutes(15),
            ]);

            $user = User::inRandomOrder()->firstOrFail();

            $booking = Booking::create([
                'location_id' => Location::firstOrFail()->id,
                'performed_by' => $user->id,
                'user_id' => $user->id,
                'started_at' => Carbon::parse($booking->ended_at)->addSecond(),
                'ended_at' => Carbon::parse($booking->ended_at)->addMinutes(30),
            ]);

            $user = User::inRandomOrder()->firstOrFail();

            $booking = Booking::create([
                'location_id' => Location::firstOrFail()->id,
                'performed_by' => $user->id,
                'user_id' => $user->id,
                'started_at' => Carbon::parse($booking->ended_at)->addSecond()->addHour(),
                'ended_at' => Carbon::parse($booking->ended_at)->addHour()->addMinutes(30),
            ]);
        }
    }
}
