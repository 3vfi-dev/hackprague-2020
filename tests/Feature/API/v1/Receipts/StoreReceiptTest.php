<?php

namespace Tests\Feature\API\v1\Receipts;

use App\Models\Company;
use App\Models\Product;
use App\Models\Receipt;
use App\Models\User;
use DateTime;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class StoreReceiptTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_it_can_store_a_receipt()
    {
        $this->withoutExceptionHandling();

        /** @var User $user */
        $user = User::factory()->create();
        /** @var Company $company */
        $company = Company::factory()->create();
        /** @var Product $product */
        $product = Product::factory()->create();

        $time = now();
        $hash = $user->generateSecret($time->timestamp);

        $data = [
            'hash' => $hash,
            'time' => $time->format(DateTime::ATOM),
            'company' => $company->getAttribute('code'),
            'fik' => Str::random(39),
            'bkp' => Str::random(44),
            'products' => [
                [
                    'code' => $product->getAttribute('code'),
                    'vat' => true,
                    'quantity' => $quantity = 5,
                ],
            ],
        ];

        $this->post(route('api.v1.receipts.store'), $data)->assertOk();

        $this->assertCount(1, Receipt::all());

        /** @var Receipt $receipt */
        $receipt = Receipt::first();

        $this->assertSame($hash, $receipt->getAttribute('hash'));
        $this->assertSame($time->timestamp, $receipt->getAttribute('paid_at'));
        $this->assertCount(1, $receipt->products);
        $this->assertSame($product->getAttribute('code'), $receipt->products->first()->getAttribute('code'));
        $this->assertSame((int) ($quantity * $product->getAttribute('price')), (int) $receipt->price_total);
        $this->assertSame($quantity, (int) $receipt->products_quantity);
    }
}
