<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'name',
        'price',
    ];

    /**
     * Get all receipts the product is in.
     *
     * @return BelongsToMany
     */
    public function receipts(): BelongsToMany
    {
        return $this->belongsToMany(Receipt::class, 'receipt_product');
    }
}
