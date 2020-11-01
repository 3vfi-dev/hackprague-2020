<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;

class Receipt extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'hash',
        'custom_text',
        'pkp',
        'fik',
        'bkp',
        'paid_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'paid_at' => 'timestamp',
    ];

    /**
     * Get the company that the receipt belongs to.
     *
     * @return BelongsTo
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Get the products in the receipt.
     *
     * @return BelongsToMany
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'receipt_product')
            ->using(ReceiptProduct::class)
            ->withPivot([
                'warranty',
                'vat',
                'price',
                'price_with_vat',
                'quantity',
                'price_total',
                'price_with_vat_total',
                'created_at',
            ]);
    }

    /**
     * Calculate prices and quantity of the products in the receipt.
     *
     * @param  array  $data
     * @param  Collection  $products
     * @return void
     */
    public function calculatePrices(array $data, Collection $products): void
    {
        $totalPrice = 0;
        $totalPriceWithVat = 0;
        $quantity = 0;

        foreach ($data as $item) {
            /** @var Product $product */
            $product = $products->where('code', $item['code'])->first();

            $totalPrice += $product->price * $item['quantity'];
            $totalPriceWithVat += $product->price * $item['quantity'] * (1 + $product->category->vat / 100);
            $quantity += $item['quantity'];
        }

        $this->setAttribute('price_total', $totalPrice);
        $this->setAttribute('price_with_vat_total', $totalPriceWithVat);
        $this->setAttribute('products_quantity', $quantity);
    }

    /**
     * Add a product to the receipt.
     *
     * @param  Product  $product
     * @param  int  $quantity
     * @param  bool  $vat  Whether VAT should be included.
     * @return void
     */
    public function attachProduct(Product $product, int $quantity, bool $vat): void
    {
        $vat = $vat ? $product->category->vat : 0;
        $price = $product->price;

        $this->products()->attach($product, [
            'warranty' => $product->warranty,
            'vat' => $vat,
            'price' => $price,
            'price_with_vat' => $price * (1 + ($vat / 100)),
            'quantity' => $quantity,
            'price_total' => $price * $quantity,
            'price_with_vat_total' => $price * $quantity * (1 + ($vat / 100)),
        ]);
    }
}
