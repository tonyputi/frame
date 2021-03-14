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
        // Booking::create([
        //     'location_id' => Location::inRandomOrder()->firstOrFail()->id,
        //     'user_id' => User::inRandomOrder()->firstOrFail()->id,
        //     'started_at' => Carbon::now()->toIso8601String(),
        //     'ended_at' => Carbon::now()->endOfHour()->toIso8601String(),
        //     'applied_at' => Carbon::now()->toIso8601String(),
        // ]);

        $booking = Booking::create([
            'location_id' => 1,
            'user_id' => User::inRandomOrder()->firstOrFail()->id,
            'started_at' => Carbon::now()->endOfMinute()->toIso8601String(),
            'ended_at' => Carbon::now()->endOfHour()->toIso8601String(),
        ]);

        $booking = Booking::create([
            'location_id' => 1,
            'user_id' => User::inRandomOrder()->firstOrFail()->id,
            'started_at' => Carbon::parse($booking->ended_at)->addSecond()->toIso8601String(),
            'ended_at' => Carbon::parse($booking->ended_at)->addMinutes(15)->toIso8601String(),
        ]);

        $booking = Booking::create([
            'location_id' => 1,
            'user_id' => User::inRandomOrder()->firstOrFail()->id,
            'started_at' => Carbon::parse($booking->ended_at)->addSecond()->toIso8601String(),
            'ended_at' => Carbon::parse($booking->ended_at)->addMinutes(30)->toIso8601String(),
        ]);

        $booking = Booking::create([
            'location_id' => 1,
            'user_id' => User::inRandomOrder()->firstOrFail()->id,
            'started_at' => Carbon::parse($booking->ended_at)->addSecond()->addHour()->toIso8601String(),
            'ended_at' => Carbon::parse($booking->ended_at)->addHour()->addMinutes(30)->toIso8601String(),
        ]);
    }
}
