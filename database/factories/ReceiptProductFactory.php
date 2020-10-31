<?php

namespace Database\Factories;

use App\Models\ReceiptProduct;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReceiptProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ReceiptProduct::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        $price = $this->faker->randomFloat(1, 1, 10000);
        $quantity = $this->faker->randomNumber(1);

        return [
            'price' => $price,
            'quantity' => $quantity,
            'price_total' => $price * $quantity,
        ];
    }
}
