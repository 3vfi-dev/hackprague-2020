<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Receipt;
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
        return [
            'price' => $this->faker->randomFloat(1, 1, 10000),
            'quantity' => $this->faker->randomNumber(2),
        ];
    }

    /**
     * Add relationships to the factory definition.
     *
     * @return ReceiptProductFactory
     */
    public function withRelationships(): self
    {
        return $this->state(static function () {
            return [
                'receipt_id' => Receipt::factory(),
                'product_id' => Product::factory(),
            ];
        });
    }
}
