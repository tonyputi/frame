<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use App\Models\Booking;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Booking::create([
            'environment_id' => 1,
            'application_id' => 1,
            'location_id' => 1,
            'user_id' => 1,
            'started_at' => Carbon::parse('+1 hour'),
            'ended_at' => Carbon::parse('+2 hour'),
            'applied_at' => Carbon::parse('+1 hour'),
        ]);
    }
}
