<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Receipt;
use Illuminate\Database\Eloquent\Factories\Factory;
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
        return [
            'company_id' => Company::factory(),
            'code' => Str::random(64),
        ];
    }
}
