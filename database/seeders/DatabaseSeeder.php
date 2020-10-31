<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Receipt;
use App\Models\ReceiptProduct;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Receipt::factory()
            ->count(10)
            ->hasAttached(
                Product::factory()->count(5),
                static function () {
                    return ReceiptProduct::factory()->raw();
                },
            )
            ->create();
    }
}
