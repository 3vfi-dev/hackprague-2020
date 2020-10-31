<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Company;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'category_id' => Category::factory(),
            'company_id' => Company::factory(),
            'code' => Str::random(64),
            'name' => $this->faker->words(3, true),
            'price' => $this->faker->randomFloat(1, 1, 10000),
            'quantity_text' => $this->faker->randomElement(['ks', 'kg', null]),
        ];
    }
}
