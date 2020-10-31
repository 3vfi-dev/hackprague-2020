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
        'code',
        'custom_text',
        'pkp',
        'fik',
        'bkp',
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
            ->withPivot(['price', 'quantity']);
    }
}
