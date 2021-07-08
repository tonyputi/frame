<?php

namespace Database\Factories;

use App\Models\Environment;
use App\Models\Location;
use Illuminate\Database\Eloquent\Factories\Factory;

class LocationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Location::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'environment_id' => fn (array $attributes) => Environment::factory()->create(),
            'name' => fn (array $attributes) => $this->faker->numerify('Location ###'),
            'match' => fn (array $attributes) => $this->faker->url(),
            'is_bookable' => true
        ];
    }
}
