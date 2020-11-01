<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
            ]);
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
