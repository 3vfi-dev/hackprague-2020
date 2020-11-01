<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Company extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'crn',
        'vat',
    ];

    /**
     * Get the address of the company.
     *
     * @return BelongsTo
     */
    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class);
    }
}
