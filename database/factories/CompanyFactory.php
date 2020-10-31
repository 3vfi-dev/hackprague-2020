<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Company::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->company,
            'crn' => $this->faker->ico,
            'vat' => 'CZ' . $this->faker->ico,
            'address_id' => Address::factory(),
        ];
    }
}
