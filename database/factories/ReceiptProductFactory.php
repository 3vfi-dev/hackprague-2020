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
        $vat = $this->faker->numberBetween(0, 21);
        $price = $this->faker->randomFloat(1, 1, 10000);
        $quantity = $this->faker->randomNumber(1) + 1;

        return [
            'vat' => $vat,
            'price' => $price,
            'price_with_vat' => $price * (1 + ($vat / 100)),
            'quantity' => $quantity,
            'price_total' => $price * $quantity,
            'price_with_vat_total' => $price * $quantity * (1 + ($vat / 100)),
            'warranty' => $this->faker->numberBetween(12, 120),
        ];
    }
}
