<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\Country;
use Illuminate\Database\Eloquent\Factories\Factory;

class AddressFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Address::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'street' => $this->faker->streetName,
            'registry_number' => $this->faker->randomNumber(4),
            'house_number' => $this->faker->randomNumber(3),
            'city' => $this->faker->city,
            'country_id' => Country::factory(),
            'lat' => $this->faker->latitude,
            'lng' => $this->faker->longitude,
        ];
    }
}
