<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Product;
use App\Models\Receipt;
use App\Models\ReceiptProduct;
use DateTime;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ReceiptFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Receipt::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        $price = $this->faker->numberBetween(100, 100000);

        return [
            'company_id' => Company::factory(),
            'hash' => Str::random(128),
            'custom_text' => $this->faker->sentence,
            'pkp' => Str::random(344),
            'fik' => Str::random(39),
            'bkp' => Str::random(44),
            'price_total' => $price,
            'price_with_vat_total' => $price * ($this->faker->numberBetween(100, 121) / 100),
            'products_quantity' => $this->faker->randomNumber(2),
            'paid_at' => $this->faker->dateTime->format(DateTime::ATOM),
        ];
    }

    /**
     * Generate random products along with the receipt.
     *
     * @param  int  $count
     * @return ReceiptFactory
     */
    public function addProducts(int $count = 5): self
    {
        $products = Product::factory()
            ->count($count)
            ->state(function (array $attributes, Model $model) {
                return ['company_id' => $model->getAttribute('company_id')];
            });

        return $this->hasAttached($products, static function () {
            return ReceiptProduct::factory()->raw();
        });
    }
}
