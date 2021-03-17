<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Booking;
use App\Models\Location;
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
        $booking = Booking::create([
            'location_id' => Location::firstOrFail()->id,
            'user_id' => User::inRandomOrder()->firstOrFail()->id,
            'started_at' => Carbon::now()->startOfMinute(),
            'ended_at' => Carbon::now()->endOfHour(),
        ]);

        $booking = Booking::create([
            'location_id' => Location::firstOrFail()->id,
            'user_id' => User::inRandomOrder()->firstOrFail()->id,
            'started_at' => Carbon::parse($booking->ended_at)->addSecond(),
            'ended_at' => Carbon::parse($booking->ended_at)->addMinutes(15),
        ]);

        $booking = Booking::create([
            'location_id' => Location::firstOrFail()->id,
            'user_id' => User::inRandomOrder()->firstOrFail()->id,
            'started_at' => Carbon::parse($booking->ended_at)->addSecond(),
            'ended_at' => Carbon::parse($booking->ended_at)->addMinutes(30),
        ]);

        $booking = Booking::create([
            'location_id' => Location::firstOrFail()->id,
            'user_id' => User::inRandomOrder()->firstOrFail()->id,
            'started_at' => Carbon::parse($booking->ended_at)->addSecond()->addHour(),
            'ended_at' => Carbon::parse($booking->ended_at)->addHour()->addMinutes(30),
        ]);
    }
}
