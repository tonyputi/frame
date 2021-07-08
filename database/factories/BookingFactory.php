<?php

namespace Database\Factories;

use App\Models\Booking;
use App\Models\Location;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class BookingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Booking::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'location_id' => fn (array $attributes) => Location::factory()->create(),
            'user_id' => fn (array $attributes) => User::factory()->create(),
            'performed_by' => fn (array $attributes) => $attributes['user_id'],
            'started_at' => function (array $attributes) {
                $booking = Booking::select('ended_at')
                    ->where('ended_at', '=>', Carbon::now())
                    ->where('location_id', $attributes['location_id'])
                    ->orderBy('ended_at', 'desc')
                    ->first();

                if (!$booking) {
                    return Carbon::now();
                }

                return $booking->ended_at->addSecond();
            },
            'ended_at' => fn (array $attributes) => Carbon::parse($attributes['started_at'])->addMinutes(15),
        ];
    }
}
